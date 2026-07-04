<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

use App\Models\Anggota;
use App\Models\KategoriLatihan;

class Evaluasi extends Model
{
	use HasDateTimeFormatter;

    protected $table = 'evaluasi';

    /*
    |--------------------------------------------------------------------------
    | RELASI ANGGOTA
    |--------------------------------------------------------------------------
    */

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KATEGORI
    |--------------------------------------------------------------------------
    */

    public function kategori()
    {
        return $this->belongsTo(KategoriLatihan::class);
    }
}