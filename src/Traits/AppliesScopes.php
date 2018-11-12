<?php

namespace Waygou\Surveyor\Traits;

use Illuminate\Support\Facades\Auth;
use Waygou\Surveyor\Bootstrap\SurveyorProvider;
use Waygou\Surveyor\Exceptions\RepositoryException;

trait AppliesScopes
{
    /**
     * Apply model global scopes given the current logged user profiles.
     *
     * @return void
     */
    public static function bootAppliesScopes()
    {
        if (SurveyorProvider::isActive()) {
            $repository = SurveyorProvider::retrieve();
            foreach ($repository['scopes'] as $model => $scopes) {
                foreach ($scopes as $scope) {
                    if (get_called_class() == $model) {
                        static::addGlobalScope(new $scope());
                    }
                }
            }
        } else {
            if (Auth::user() != null) {
                // Surveyor needs to be active. Throw exception.
                throw RepositoryException::notInitialized();
            }
        }
    }
}
