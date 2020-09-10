<?php

namespace App\Admin\Repositories;

use App\Models\OaDiary as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class OaDiary extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
