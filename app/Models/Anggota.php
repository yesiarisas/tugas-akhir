<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $fillable = [
        'kategori_id',
        'nama',
        'tanggal_lahir',
        'no_hp',
        'alamat',
        'tanggal_gabung',
        'kode_anggota',
        'email',
        'password',
        'sudah_aktivasi'
    ];

    public function kategori()
    {
        return $this->belongsTo(
            KategoriLatihan::class,
            'kategori_id'
        );
    }

    public function getKelasAttribute()
    {
        if (!$this->tanggal_lahir) {
            return '-';
        }

        $umur = Carbon::parse(
            $this->tanggal_lahir
        )->age;

        if ($umur <= 6) return 'TK';
        if ($umur <= 12) return 'SD';
        if ($umur <= 15) return 'SMP';
        if ($umur <= 18) return 'SMA';

        return 'Dewasa';
    }
}