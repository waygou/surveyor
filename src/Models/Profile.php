<?php

namespace Waygou\Surveyor\Models;

use Waygou\Surveyor\Abstracts\SurveyorModel;

class Profile extends SurveyorModel
{
    public function users()
    {
        return $this->belongsToMany(config('surveyor.user_class'))->withTimestamps();
    }

    public function scopes()
    {
        return $this->belongsToMany(Scope::class)->withTimestamps();
    }

    public function policies()
    {
        return $this->belongsToMany(Policy::class)->withPivot(
            'can_view_any',
            'can_view',
            'can_create',
            'can_update',
            'can_delete',
            'can_force_delete',
            'can_restore'
        )->withTimestamps();
    }
}
