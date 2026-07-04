<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class GaleriPrestasi extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'galeri_prestasi';
    
}
