<?php

namespace App\Admin\Repositories;

use App\Models\Anggota as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Anggota extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
