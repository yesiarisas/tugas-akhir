<?php

namespace App\Admin\Repositories;

use App\Models\Pembayaran as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Pembayaran extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
