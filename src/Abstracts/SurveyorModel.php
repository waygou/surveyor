<?php

namespace Waygou\Surveyor\Abstracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Waygou\Helpers\Traits\CanSaveMany;

abstract class SurveyorModel extends Model
{
    use SoftDeletes;
    use CanSaveMany;

    protected $guarded = [];
}
