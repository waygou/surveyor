<?php

namespace Waygou\Surveyor\Traits;

use Waygou\Surveyor\Bootstrap\SurveyorProvider;
use Illuminate\Auth\Access\HandlesAuthorization;

trait AppliesPolicies
{
    private $repository;

    use HandlesAuthorization;

    public function __construct()
    {
        $this->repository = SurveyorProvider::retrieve();
    }

    public function viewAny()
    {
        return SurveyorProvider::can(get_called_class(), 'viewAny');
    }

    public function view()
    {
        return $this->repository['policy'][get_called_class()]['view'];
    }

    public function create()
    {
        return $this->repository['policy'][get_called_class()]['create'];
    }

    public function update()
    {
        return $this->repository['policy'][get_called_class()]['update'];
    }

    public function delete()
    {
        return $this->repository['policy'][get_called_class()]['delete'];
    }

    public function restore()
    {
        return $this->repository['policy'][get_called_class()]['restore'];
    }

    public function forceDelete()
    {
        return $this->repository['policy'][get_called_class()]['forceDelete'];
    }
}
