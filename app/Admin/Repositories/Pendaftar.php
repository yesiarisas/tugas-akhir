<?php

namespace App\Admin\Repositories;

use App\Models\Pendaftar as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Pendaftar extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
