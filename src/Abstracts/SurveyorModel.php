<?php

namespace Waygou\Surveyor\Abstracts;

use Waygou\Helpers\Traits\CanSaveMany;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class SurveyorModel extends Model
{
    use UsesTenantConnection;
    use SoftDeletes;
    use CanSaveMany;

    protected $guarded = [];
}
