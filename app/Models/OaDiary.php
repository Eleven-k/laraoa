<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class OaDiary extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'oa_diaries';
    
}
