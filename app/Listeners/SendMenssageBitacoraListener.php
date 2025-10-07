<?php

namespace App\Listeners;

use App\Events\SendMenssageBitacoraEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMenssageBitacoraListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendMenssageBitacoraEvent  $event
     * @return void
     */
    public function handle(SendMenssageBitacoraEvent $event)
    {
        //
    }
}
