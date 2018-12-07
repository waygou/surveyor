<?php

namespace Waygou\Surveyor\Abstracts;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Waygou\Helpers\Traits\CanSaveMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class SurveyorModel extends Model
{
    use UsesTenantConnection;
    use SoftDeletes;
    use CanSaveMany;

    protected $guarded = [];
}
