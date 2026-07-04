<?php

namespace App\Admin\Repositories;

use App\Models\Evaluasi as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Evaluasi extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
