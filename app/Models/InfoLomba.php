<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class InfoLomba extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'info_lomba';
    
}
