<?php

namespace Waygou\Surveyor\Bootstrap;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Waygou\Surveyor\Exceptions\RepositoryException;

class SurveyorProvider
{
    public static function init()
    {
        /*
         * Surveyor constructs your user structure into Laravel cache.
         * Reason is it's faster to access since it will run on each request
         * action.
         * Ideally you should cache into a in-memory database like Redis.
         * The Surveyor repository defines:
         * - User information.
         * - User profiles.
         * - User profile scopes.
         * - User profile policies.
         * - User policy actions per policy.
         */

        // Security validation.
        // The current logged user id is equal to the Surveyor user id?
        if (Auth::id() != null && static::isActive()) {
            $repository = static::retrieve();
            if (data_get($repository, 'user.id') != Auth::id()) {
                static::flush();
            }
        }

        if (Auth::id() != null && !static::isActive()) {
            $repository = [];
            $repository['scopes'] = [];
            $repository['policies'] = [];
            $repository['policy'] = [];

            data_set($repository, 'user.id', Auth::id());

            if (!is_null(me()->profiles)) {
                foreach (me()->profiles as $profile) {
                    $repository['profiles'][$profile->code] = ['id'   => $profile->id,
                                                               'code' => $profile->code,
                                                               'name' => $profile->name, ];

                    foreach ($profile->scopes as $scope) {
                        $repository['scopes'][$scope->model][] = $scope->scope;
                    }

                    foreach ($profile->policies as $policy) {
                        $repository['policies'][$policy->model] = $policy->policy;

                        $repository['policy'][$policy->policy] = [
                          'viewAny'     => $policy->pivot->can_view_any,
                          'view'        => $policy->pivot->can_view,
                          'create'      => $policy->pivot->can_create,
                          'update'      => $policy->pivot->can_update,
                          'delete'      => $policy->pivot->can_delete,
                          'forceDelete' => $policy->pivot->can_force_delete,
                          'restore'     => $policy->pivot->can_restore, ];
                    }
                }
            }

            static::store($repository);
        }
    }

    private static function store($repository)
    {
        @session_start();
        $_SESSION['surveyor'] = $repository;
    }

    public static function retrieve()
    {
        @session_start();
        if (array_key_exists('surveyor', $_SESSION)) {
            return $_SESSION['surveyor'];
        }

        throw RepositoryException::notInitialized();
    }

    public static function isActive()
    {
        @session_start();
        if (array_key_exists('surveyor', $_SESSION)) {
            return true;
        }

        return false;
    }

    public static function flush()
    {
        @session_start();
        if (array_key_exists('surveyor', $_SESSION)) {
            unset($_SESSION['surveyor']);
        }
    }

    public static function applyPolicies()
    {
        if (static::isActive()) {
            $repository = static::retrieve();

            foreach ($repository['policies'] as $model => $policy) {
                Gate::policy($model, $policy);
            }
        }
    }

    public static function add($path, $value)
    {
        if (static::isActive()) {
            $repository = static::retrieve();
            data_set($repository, $path, $value);
            static::store($repository);
        }
    }

    public static function can($policy, $action)
    {
        if (static::isActive()) {
            $repository = static::retrieve();
            $path = "policy.{$policy}.{$action}";
            if (static::contains($path)) {
                return (bool) data_get($repository, $path);
            } else {
                return false;
            }
        }
    }

    public static function contains($path)
    {
        if (static::isActive()) {
            $repository = static::retrieve();

            return data_get($repository, $path);
        }
    }
}
