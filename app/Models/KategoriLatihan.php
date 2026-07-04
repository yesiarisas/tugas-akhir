<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class KategoriLatihan extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'kategori_latihan';
    
}
