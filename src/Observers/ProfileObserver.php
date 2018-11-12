<?php

namespace Waygou\Surveyor\Observers;

use Waygou\Surveyor\Models\Profile;

class ProfileObserver
{
    public function saving(Profile $model)
    {
        // Snake case 'code' attribute, in case it comes empty.
        if (empty($model->code)) {
            $model->code = str_slug($model->name);
        }
    }

    public function created(Profile $model)
    {
        //
    }

    public function updated(Profile $model)
    {
        //
    }

    public function deleted(Profile $model)
    {
        //
    }

    public function forceDeleted(Profile $model)
    {
        //
    }
}
