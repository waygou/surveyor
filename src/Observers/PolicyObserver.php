<?php

namespace Waygou\Surveyor\Observers;

use Waygou\Surveyor\Models\Policy;

class PolicyObserver
{
    public function saving(Policy $model)
    {
        if ($model->policy[0] == '\\') {
            $model->policy = substr($model->policy, 1);
        }

        if ($model->model[0] == '\\') {
            $model->model = substr($model->model, 1);
        }

        // Snake case 'code' attribute, in case it comes empty.
        if (empty($model->code)) {
            $model->code = str_slug($model->name);
        }
    }

    public function created(Policy $model)
    {
        //
    }

    public function updated(Policy $model)
    {
        //
    }

    public function deleted(Policy $model)
    {
        //
    }

    public function forceDeleted(Policy $model)
    {
        //
    }
}
