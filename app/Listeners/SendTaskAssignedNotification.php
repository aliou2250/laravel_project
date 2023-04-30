<?php

namespace App\Listeners;

use App\Events\TaskAssigned;
use App\Mail\TaskAssignedNotification;
use Illuminate\Support\Facades\Mail;

class SendTaskAssignedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskAssigned $event): void
    {
        //
        $task = $event->task;
        $user = $event->user;

        Mail::to($user->email)->send(new TaskAssignedNotification($task, $user));
    }
}
