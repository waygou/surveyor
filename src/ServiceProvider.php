<?php

namespace Waygou\Surveyor;

use Waygou\Surveyor\Models\Scope;
use Waygou\Surveyor\Models\Policy;
use Waygou\Surveyor\Models\Profile;
use Illuminate\Support\Facades\Event;
use Waygou\Surveyor\Listeners\BootSurveyor;
use Waygou\Surveyor\Listeners\FlushSurveyor;
use Waygou\Surveyor\Observers\ScopeObserver;
use Waygou\Surveyor\Observers\PolicyObserver;
use Waygou\Surveyor\Observers\ProfileObserver;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->registerObservers();

        $this->registerListeners();

        $this->registerPublishing();
    }

    protected function registerPublishing()
    {
        if (! class_exists('CreateSurveyorSchema')) {
            $timestamp = date('Y_m_d_His', time());
            $this->publishes([
                __DIR__.'/../database/migrations/create_surveyor_schema.php.stub' => $this->app->databasePath()."/migrations/{$timestamp}_create_surveyor_schema.php",
            ], 'surveyor-create-schema');
        }

        $this->publishes([
            __DIR__.'/../config/surveyor.php' => config_path('surveyor.php'),
        ], 'surveyor-config');
    }

    protected function registerListeners()
    {
        Event::listen('Illuminate\Auth\Events\Authenticated', function ($authenticated) {
            return (new BootSurveyor($authenticated))->handle();
        });

        Event::listen('Illuminate\Auth\Events\Logout', function ($logout) {
            return (new FlushSurveyor($logout))->handle();
        });

        Event::listen('Illuminate\Auth\Events\Failed', function ($logout) {
            return (new FlushSurveyor($logout))->handle();
        });
    }

    protected function registerObservers()
    {
        Profile::observe(ProfileObserver::class);
        Scope::observe(ScopeObserver::class);
        Policy::observe(PolicyObserver::class);
    }
}
