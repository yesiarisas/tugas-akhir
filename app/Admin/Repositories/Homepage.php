<?php

namespace App\Admin\Repositories;

use App\Models\Homepage as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Homepage extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
