<?php

namespace App\Admin\Controllers;

use App\Models\Agenda;
use App\Models\Anggota;
use App\Models\Evaluasi;
use App\Models\Pembayaran;
use App\Models\Pengumuman;
use App\Models\JadwalLatihan;
use App\Models\KategoriLatihan;

use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Content;

class HomeController extends Controller
{
    public function index(Content $content)
    {

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalAnggota = Anggota::count();

        $totalLunas = Pembayaran::where('status', 'Lunas')->count();

        $totalBelumBayar = Pembayaran::where('status', '!=', 'Lunas')->count();

        /*
        |--------------------------------------------------------------------------
        | PENGUMUMAN
        |--------------------------------------------------------------------------
        */

        $pengumuman = Pengumuman::latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | AGENDA
        |--------------------------------------------------------------------------
        */

        $agenda = Agenda::latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | JADWAL LATIHAN
        |--------------------------------------------------------------------------
        */

        $jadwal = JadwalLatihan::where('status', 'aktif')
            ->orderBy('kategori_id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | GRAFIK BULANAN
        |--------------------------------------------------------------------------
        */

        $evaluasiBulanan = Evaluasi::orderBy('tanggal_evaluasi')
            ->get()
            ->groupBy(function ($item) {

                return Carbon::parse($item->tanggal_evaluasi)
                    ->translatedFormat('M');
            });

        $labels = [];

        $nilaiSkill = [];

        $nilaiDisiplin = [];

        foreach ($evaluasiBulanan as $bulan => $items) {

            $avgSkill = $items->avg('nilai_teknik');

            $avgDisiplin = $items->avg('nilai_kedisiplinan');

            if ($avgSkill <= 10) {
                $avgSkill = $avgSkill * 10;
            }

            if ($avgDisiplin <= 10) {
                $avgDisiplin = $avgDisiplin * 10;
            }

            $labels[] = $bulan;

            $nilaiSkill[] = round($avgSkill, 1);

            $nilaiDisiplin[] = round($avgDisiplin, 1);
        }

        $labelsJson = json_encode($labels);

        $skillJson = json_encode($nilaiSkill);

        $disiplinJson = json_encode($nilaiDisiplin);

        /*
        |--------------------------------------------------------------------------
        | FUNCTION TOP NILAI
        |--------------------------------------------------------------------------
        */

        $getTopKategoriJenjang = function (
            $kategoriId,
            $minUmur,
            $maxUmur = null
        ) {

            $query = Evaluasi::with('anggota')

                ->whereHas('anggota', function (
                    $q
                ) use (
                    $kategoriId,
                    $minUmur,
                    $maxUmur
                ) {

                    $q->where('kategori_id', $kategoriId);

                    if ($maxUmur !== null) {

                        $q->whereRaw("
                            TIMESTAMPDIFF(
                                YEAR,
                                tanggal_lahir,
                                CURDATE()
                            ) BETWEEN {$minUmur}
                            AND {$maxUmur}
                        ");
                    } else {

                        $q->whereRaw("
                            TIMESTAMPDIFF(
                                YEAR,
                                tanggal_lahir,
                                CURDATE()
                            ) >= {$minUmur}
                        ");
                    }
                })

                ->selectRaw("
                    anggota_id,

                    MAX(
                        (
                            nilai_teknik +
                            nilai_kedisiplinan +
                            nilai_kehadiran
                        ) / 3
                    ) as rata_rata
                ")

                ->groupBy('anggota_id')

                ->orderByDesc('rata_rata')

                ->take(5);

            return $query->get();
        };

        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        $kategori = KategoriLatihan::all();

        /*
        |--------------------------------------------------------------------------
        | CSS
        |--------------------------------------------------------------------------
        */

        Admin::style(<<<CSS

        .content-wrapper{
            background:#ece7dd !important;
        }

        .dashboard-card{
            background:white;
            border-radius:20px;
            padding:20px;
            margin-bottom:20px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
        }

        /*
        |--------------------------------------------------------------------------
        | STAT CARD
        |--------------------------------------------------------------------------
        */

        .stat-card{
            border-radius:18px;
            padding:22px;
            color:white;
            margin-bottom:20px;
        }

        .bg-blue{
            background:#3559e0;
        }

        .bg-green{
            background:#16a34a;
        }

        .bg-red{
            background:#dc2626;
        }

        .stat-card h2{
            font-size:30px;
            margin:0;
            font-weight:bold;
        }

        .stat-card p{
            margin-top:8px;
            margin-bottom:0;
            font-size:14px;
        }

        /*
        |--------------------------------------------------------------------------
        | TITLE
        |--------------------------------------------------------------------------
        */

        .dashboard-title{
            font-size:20px;
            font-weight:bold;
            margin-bottom:20px;
        }

        .mini-title{
            text-align:center;
            font-size:14px;
            font-weight:bold;
            margin-bottom:10px;
            padding-bottom:6px;
            border-bottom:2px solid #eee;
        }

        /*
        |--------------------------------------------------------------------------
        | TOP ROW
        |--------------------------------------------------------------------------
        */

        .top-single-row{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:14px;
            padding:0 10px 8px 10px;
            overflow-x:auto;
        }

        .top-single-row::-webkit-scrollbar{
            height:5px;
        }

        .top-single-row::-webkit-scrollbar-thumb{
            background:#d1d5db;
            border-radius:10px;
        }

        /*
        |--------------------------------------------------------------------------
        | TOP ITEM
        |--------------------------------------------------------------------------
        */

        .top-item{
            flex:1;
            min-width:160px;
            max-width:190px;
            background:#fcfcfc;
            border:1px solid #ececec;
            border-radius:14px;
            padding:10px;
        }

        /*
        |--------------------------------------------------------------------------
        | MEMBER CARD
        |--------------------------------------------------------------------------
        */

        .member-card{
            display:flex;
            align-items:center;
            background:white;
            border-radius:10px;
            padding:7px;
            margin-bottom:7px;
            border:1px solid #f0f0f0;
        }

        .member-rank{
            width:28px;
            height:28px;
            border-radius:50%;
            background:#3559e0;
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:10px;
            font-weight:bold;
            margin-right:8px;
            flex-shrink:0;
        }

        .member-name{
            font-size:11px;
            font-weight:bold;
            line-height:1.2;
        }

        .member-score{
            font-size:10px;
            color:#666;
        }

        /*
        |--------------------------------------------------------------------------
        | JADWAL
        |--------------------------------------------------------------------------
        */

        .jadwal-item{
            background:#f8fafc;
            border-radius:14px;
            padding:15px;
            border:1px solid #e2e8f0;
            margin-bottom:15px;
        }

        .jadwal-title{
            font-size:15px;
            font-weight:bold;
            margin-bottom:10px;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLE
        |--------------------------------------------------------------------------
        */

        table td{
            padding:6px !important;
            font-size:13px;
        }

        /*
        |--------------------------------------------------------------------------
        | CHART
        |--------------------------------------------------------------------------
        */

        canvas{
            max-height:320px !important;
        }

        CSS);

        /*
        |--------------------------------------------------------------------------
        | SCRIPT
        |--------------------------------------------------------------------------
        */

        Admin::script(<<<JS

        setTimeout(function(){

            new Chart(document.getElementById('barChart'), {

                type: 'bar',

                data: {

                    labels: {$labelsJson},

                    datasets: [

                        {
                            label: 'Skill',
                            data: {$skillJson},
                            backgroundColor:'#4f46e5'
                        },

                        {
                            label: 'Disiplin',
                            data: {$disiplinJson},
                            backgroundColor:'#cbd5e1'
                        }
                    ]
                },

                options: {

                    responsive:true,

                    plugins:{
                        legend:{
                            position:'bottom'
                        }
                    },

                    scales:{

                        y:{
                            beginAtZero:true,
                            max:100
                        }
                    }
                }
            });

        },500);

        JS);

        /*
        |--------------------------------------------------------------------------
        | HTML
        |--------------------------------------------------------------------------
        */

        $html = "

        <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>

        <div class='row'>

            <div class='col-md-4'>
                <div class='stat-card bg-blue'>
                    <h2>{$totalAnggota}</h2>
                    <p>Total Anggota</p>
                </div>
            </div>

            <div class='col-md-4'>
                <div class='stat-card bg-green'>
                    <h2>{$totalLunas}</h2>
                    <p>Pembayaran Lunas</p>
                </div>
            </div>

            <div class='col-md-4'>
                <div class='stat-card bg-red'>
                    <h2>{$totalBelumBayar}</h2>
                    <p>Belum Bayar</p>
                </div>
            </div>

        </div>

        <div class='dashboard-card'>

            <div class='dashboard-title'>
                Rekap Grafik Perkembangan Anggota
            </div>

            <canvas id='barChart' height='90'></canvas>

        </div>
        ";

        /*
        |--------------------------------------------------------------------------
        | TOP NILAI
        |--------------------------------------------------------------------------
        */

        foreach ($kategori as $kat) {

            $html .= "

            <div class='dashboard-card'>

                <div class='dashboard-title'>
                    Top {$kat->nama_kategori}
                </div>

                <div class='top-single-row'>
            ";

            $jenjangData = [

                'TK' => $getTopKategoriJenjang($kat->id, 0, 6),
                'SD' => $getTopKategoriJenjang($kat->id, 7, 12),
                'SMP' => $getTopKategoriJenjang($kat->id, 13, 15),
                'SMA' => $getTopKategoriJenjang($kat->id, 16, 18),
                'UMUM' => $getTopKategoriJenjang($kat->id, 19),

            ];

            foreach ($jenjangData as $jenjang => $items) {

                $html .= "

                <div class='top-item'>

                    <div class='mini-title'>
                        {$jenjang}
                    </div>
                ";

                foreach ($items as $index => $item) {

                    $ranking = $index + 1;

                    $nama = optional($item->anggota)->nama ?? '-';

                    $nilai = round($item->rata_rata, 1);

                    $html .= "

                    <div class='member-card'>

                        <div class='member-rank'>
                            #{$ranking}
                        </div>

                        <div>

                            <div class='member-name'>
                                {$nama}
                            </div>

                            <div class='member-score'>
                                Nilai : {$nilai}
                            </div>

                        </div>

                    </div>
                    ";
                }

                $html .= "
                </div>
                ";
            }

            $html .= "

                </div>

            </div>
            ";
        }

        /*
        |--------------------------------------------------------------------------
        | JADWAL
        |--------------------------------------------------------------------------
        */

        $html .= "

        <div class='dashboard-card'>

            <div class='dashboard-title'>
                Jadwal Latihan
            </div>

            <div class='row'>
        ";

        foreach ($jadwal as $item) {

            $kategoriNama = optional(
                KategoriLatihan::find($item->kategori_id)
            )->nama_kategori ?? '-';

            $jam =
                substr($item->jam_mulai,0,5)
                .' - '.
                substr($item->jam_selesai,0,5);

            $html .= "

            <div class='col-md-6'>

                <div class='jadwal-item'>

                    <div class='jadwal-title'>
                        {$kategoriNama}
                    </div>

                    <table class='table table-borderless'>

                        <tr>
                            <td width='100'>Hari</td>
                            <td>{$item->hari}</td>
                        </tr>

                        <tr>
                            <td>Jam</td>
                            <td>{$jam}</td>
                        </tr>

                        <tr>
                            <td>Lokasi</td>
                            <td>{$item->lokasi}</td>
                        </tr>

                    </table>

                </div>

            </div>

            ";
        }

        $html .= "

            </div>

        </div>

        <div class='row'>

            <div class='col-md-6'>

                <div class='dashboard-card'>

                    <div class='mini-title'>
                        Pengumuman Terbaru
                    </div>

                    <table class='table table-borderless'>
        ";

        foreach ($pengumuman as $item) {

            $judul = $item->judul ?? '-';

            $html .= "

                <tr>
                    <td>{$judul}</td>
                </tr>
            ";
        }

        $html .= "

                    </table>

                </div>

            </div>

            <div class='col-md-6'>

                <div class='dashboard-card'>

                    <div class='mini-title'>
                        Agenda Terbaru
                    </div>

                    <table class='table table-borderless'>
        ";

        foreach ($agenda as $item) {

            $judul = $item->judul ?? '-';

            $html .= "

                <tr>
                    <td>{$judul}</td>
                </tr>
            ";
        }

        $html .= "

                    </table>

                </div>

            </div>

        </div>
        ";

        return $content
            ->title('')
            ->description('')
            ->body($html);
    }
}