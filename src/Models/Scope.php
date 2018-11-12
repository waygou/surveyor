<?php

namespace Waygou\Surveyor\Models;

use Waygou\Surveyor\Abstracts\SurveyorModel;

class Scope extends SurveyorModel
{
    public function profiles()
    {
        return $this->belongsToMany(Profile::class)->withTimestamps();
    }
}
