<?php

namespace Waygou\Surveyor\Listeners;

use Waygou\Surveyor\Bootstrap\SurveyorProvider;

class BootSurveyor
{
    public $authenticated;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct($authenticated)
    {
        $this->authenticated = $authenticated;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle()
    {
        SurveyorProvider::init();
        SurveyorProvider::applyPolicies();
    }
}
