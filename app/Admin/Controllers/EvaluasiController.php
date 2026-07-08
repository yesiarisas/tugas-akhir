<?php

namespace App\Admin\Controllers;

use App\Models\Anggota;
use App\Models\Evaluasi;
use App\Models\KategoriLatihan;

use Carbon\Carbon;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\ApexCharts\Chart;

class EvaluasiController extends AdminController
{
    /**
     * LIST ANGGOTA
     */
    protected function grid()
    {
        return Grid::make(new Anggota(), function (Grid $grid) {

            /**
             * QUICK SEARCH (Fitur Pencarian Cepat - Tetap Dipertahankan)
             */
            $grid->quickSearch('nama');

            /**
             * URUT BERDASARKAN UMUR
             * TK -> SD -> SMP -> SMA -> UMUM
             */
            $grid->model()
                ->orderByRaw("
                    CASE
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 6 THEN 1
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 12 THEN 2
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 15 THEN 3
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 18 THEN 4
                        ELSE 5
                    END
                ")
                ->orderBy('tanggal_lahir', 'desc');

            /**
             * KOLOM
             */
            $grid->column('id', 'ID');

            $grid->column('nama', 'Nama');

            $grid->column('tanggal_lahir', 'Tanggal Lahir');

            /**
             * JENJANG
             */
            $grid->column('jenjang', 'Jenjang')
                ->display(function () {

                    if (!$this->tanggal_lahir) {
                        return '-';
                    }

                    $umur = Carbon::parse($this->tanggal_lahir)->age;

                    if ($umur <= 6) {
                        return 'TK';
                    }

                    if ($umur <= 12) {
                        return 'SD';
                    }

                    if ($umur <= 15) {
                        return 'SMP';
                    }

                    if ($umur <= 18) {
                        return 'SMA';
                    }

                    return 'UMUM';
                });

            /**
             * KATEGORI
             */
            $grid->column('kategori_id', 'Kategori')
                ->display(function ($id) {

                    $kategori = KategoriLatihan::find($id);

                    return $kategori
                        ? $kategori->nama_kategori
                        : '-';
                });

            /**
             * NILAI TERAKHIR
             */
            $grid->column('rata_rata', 'Rata-rata Terakhir')
                ->display(function () {

                    $nilai = Evaluasi::where('anggota_id', $this->id)
                        ->latest()
                        ->first();

                    if (!$nilai) {
                        return '-';
                    }

                    $rata =
                        (
                            $nilai->nilai_teknik +
                            $nilai->nilai_kedisiplinan +
                            $nilai->nilai_kehadiran
                        ) / 3;

                    return round($rata, 1);
                });

            /**
             * AKSI
             */
            $grid->actions(function ($actions) {

                $id = $actions->row->id;

                /**
                 * TAMBAH
                 */
                $actions->append(
                    "<a href='/admin/evaluasi/create?anggota_id=$id'
                        class='btn btn-sm btn-primary'>
                        Tambah
                    </a>"
                );

                /**
                 * RIWAYAT
                 */
                $actions->append(
                    "<a href='/admin/evaluasi/riwayat/$id'
                        class='btn btn-sm btn-info'>
                        Riwayat
                    </a>"
                );

                /**
                 * GRAFIK
                 */
                $actions->append(
                    "<a href='/admin/evaluasi/grafik/$id'
                        class='btn btn-sm btn-success'>
                        Grafik
                    </a>"
                );
            });

            /**
             * DISABLE BUTTONS
             */
            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->disableViewButton();

            /**
             * FILTER TOMBOL DIHAPUS (disableFilter)
             */
            $grid->disableFilter();
        });
    }

    /**
     * FORM TAMBAH EVALUASI
     */
    protected function form()
    {
        return Form::make(new Evaluasi(), function (Form $form) {

            $form->display('id');

            // Ambil ID Anggota dari URL parameter (?anggota_id=xx)
            $anggotaId = request('anggota_id');

            /**
             * NAMA & KATEGORI OTOMATIS (READ-ONLY)
             */
            if ($anggotaId && $form->isCreating()) {
                $anggota = Anggota::find($anggotaId);
                
                if ($anggota) {
                    // Tampilkan Nama Anggota sebagai teks (Tidak bisa diedit)
                    $form->display('anggota_nama', 'Nama')->default($anggota->nama);
                    $form->hidden('anggota_id')->default($anggota->id);

                    // Ambil Kategori otomatis dari data anggota
                    $kategori = KategoriLatihan::find($anggota->kategori_id);
                    $namaKategori = $kategori ? $kategori->nama_kategori : '-';
                    
                    // Tampilkan Kategori sebagai teks (Tidak bisa diedit)
                    $form->display('kategori_nama', 'Kategori')->default($namaKategori);
                    $form->hidden('kategori_id')->default($anggota->kategori_id);
                }
            } else {
                // Fallback jika form diakses secara manual atau mode edit normal
                $form->select('anggota_id', 'Nama')
                    ->options(Anggota::pluck('nama', 'id'))
                    ->required();

                $form->select('kategori_id', 'Kategori')
                    ->options(KategoriLatihan::pluck('nama_kategori', 'id'))
                    ->required();
            }

            /**
             * TANGGAL
             */
            $form->date('tanggal_evaluasi', 'Tanggal Evaluasi')
                ->default(date('Y-m-d'))
                ->required();

            /**
             * NILAI (Berupa input teks angka langsung tanpa tombol plus minus)
             * Batasan input tetap minimal 1 dan maksimal 100
             */
            $form->text('nilai_teknik', 'Nilai Teknik')
                ->type('number')
                ->attribute('min', 1)
                ->attribute('max', 100)
                ->rules('required|integer|min:1|max:100')
                ->required();

            $form->text('nilai_kedisiplinan', 'Nilai Disiplin')
                ->type('number')
                ->attribute('min', 1)
                ->attribute('max', 100)
                ->rules('required|integer|min:1|max:100')
                ->required();

            $form->text('nilai_kehadiran', 'Nilai Kehadiran')
                ->type('number')
                ->attribute('min', 1)
                ->attribute('max', 100)
                ->rules('required|integer|min:1|max:100')
                ->required();
                
            /**
             * CATATAN
             */
            $form->textarea('catatan', 'Catatan');

            $form->display('created_at');
            $form->display('updated_at');

            /**
             * FOOTER CONFIGURATION (Hanya Aktifkan Submit)
             */
            $form->footer(function ($footer) {
                $footer->disableReset();          // Hapus tombol Reset
                $footer->disableViewCheck();      // Hapus checkbox View
                $footer->disableEditingCheck();   // Hapus checkbox Continue editing
                $footer->disableCreatingCheck();  // Hapus checkbox Continue creating
            });
        });
    }

    /**
     * RIWAYAT EVALUASI
     */
    public function riwayat(Content $content, $id)
    {
        $anggota = Anggota::findOrFail($id);

        return $content
            ->title('Riwayat Evaluasi')
            ->description($anggota->nama)
            ->body(

                Grid::make(new Evaluasi(), function (Grid $grid) use ($id) {

                    $grid->model()
                        ->where('anggota_id', $id)
                        ->orderBy('tanggal_evaluasi', 'desc');

                    /**
                     * KOLOM
                     */
                    $grid->column('tanggal_evaluasi', 'Tanggal');
                    $grid->column('nilai_teknik', 'Teknik');
                    $grid->column('nilai_kedisiplinan', 'Disiplin');
                    $grid->column('nilai_kehadiran', 'Kehadiran');
                    $grid->column('catatan', 'Catatan');

                    /**
                     * DISABLE BUTTONS
                     */
                    $grid->disableCreateButton();
                    $grid->disableEditButton();
                    $grid->disableDeleteButton();
                    $grid->disableViewButton();
                })
            );
    }

     /**
     * GRAFIK PERKEMBANGAN
     */
    public function grafik(Content $content, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $evaluasi = Evaluasi::where('anggota_id', $id)
            ->orderBy('tanggal_evaluasi')
            ->get();

        /**
         * ARRAY
         */
        $label = [];
        $teknik = [];
        $disiplin = [];
        $kehadiran = [];

        foreach ($evaluasi as $item) {

            /**
             * BULAN
             */
            $bulan = Carbon::parse($item->tanggal_evaluasi)
                ->translatedFormat('M');

            /**
             * MINGGU KE BERAPA
             */
            $tanggal = Carbon::parse($item->tanggal_evaluasi);
            $minggu = ceil($tanggal->day / 7);

            /**
             * LABEL (Contoh: Mei-M1)
             */
            $label[] = $bulan . '-M' . $minggu;

            /**
             * DATA
             */
            $teknik[] = (int) $item->nilai_teknik;
            $disiplin[] = (int) $item->nilai_kedisiplinan;
            $kehadiran[] = (int) $item->nilai_kehadiran;
        }

        /**
         * CHART
         */
        $chart = new Chart();

        $chart->options([
            'chart' => [
                'type' => 'bar',
                'height' => 500,
                'stacked' => false,
            ],
            'series' => [
                [
                    'name' => 'Teknik',
                    'data' => $teknik,
                ],
                [
                    'name' => 'Disiplin',
                    'data' => $disiplin,
                ],
                [
                    'name' => 'Kehadiran',
                    'data' => $kehadiran,
                ],
            ],
            'xaxis' => [
                'categories' => $label,
            ],
            'yaxis' => [
                'min' => 0,
                'max' => 100,
            ],
            'legend' => [
                'position' => 'top',
            ],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                    'columnWidth' => '60%',
                ],
            ],
            'dataLabels' => [
                'enabled' => true,
            ],
        ]);

        return $content
            ->title('Grafik Perkembangan')
            ->description($anggota->nama)
            ->body($chart);
    }

    /**
     * DETAIL
     */
    protected function detail($id)
    {
        return Show::make($id, new Evaluasi(), function (Show $show) {
            $show->field('anggota.nama', 'Nama');
            $show->field('kategori.nama_kategori', 'Kategori');
            $show->field('tanggal_evaluasi', 'Tanggal');
            $show->field('nilai_teknik', 'Nilai Teknik');
            $show->field('nilai_kedisiplinan', 'Nilai Kedisiplinan');
            $show->field('nilai_kehadiran', 'Nilai Kehadiran');
            $show->field('catatan', 'Catatan');
        });
    }
}