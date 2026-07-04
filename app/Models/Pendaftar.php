<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    protected $table = 'pendaftar';

    protected $fillable = [
        'kategori_id',
        'nama_pendaftar',
        'tanggal_lahir',
        'no_hp',
        'alamat',
        'tanggal_daftar',
        'status',
        'catatan_admin',
        'sudah_register',
        'anggota_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriLatihan::class, 'kategori_id');
    }

    // 🔥 WAJIB INI
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }
}