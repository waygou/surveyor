<?php

namespace Waygou\Surveyor\Listeners;

use Waygou\Surveyor\Bootstrap\SurveyorProvider;

class FlushSurveyor
{
    public $event;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
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
        SurveyorProvider::flush();
    }
}
