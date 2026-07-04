<?php

namespace App\Admin\Repositories;

use App\Models\InfoLomba as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class InfoLomba extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
