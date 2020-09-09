<?php

namespace App\Admin\Repositories;

use App\Models\OaLog as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class OaLog extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
