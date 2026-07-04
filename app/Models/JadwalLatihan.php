<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalLatihan extends Model
{
    protected $table = 'jadwal_latihan';

    protected $fillable = [
        'kategori_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'keterangan',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriLatihan::class, 'kategori_id');
    }
}