<?php

namespace App\Console\Commands;

use App\Mail\TaskDueNotification;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDueTaskNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-due-task-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $tasks = Task::whereDate('due_date', Carbon::today())->get();

        foreach ($tasks as $task) {
            // $user = User::find($task->assignee_id);
            if ($task->assignee_id) {
                Mail::to($task->assignee->email)->send(new TaskDueNotification($task));
            }
        }

        $this->info('Task due alerts sent successfully.');
    }
}
