<?php

namespace App\Admin\Repositories;

use App\Models\JadwalLatihan as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class JadwalLatihan extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
