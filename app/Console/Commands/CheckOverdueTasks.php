<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Mail\OverdueTaskReminder;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckOverdueTasks extends Command
{
    protected $signature = 'tasks:check-overdue';

    protected $description = 'Check overdue tasks and send reminder emails to users';

    public function handle()
    {
        $overdueTasks = Task::where('due_date', '<', Carbon::now())
                            ->where('status', '!=', 'completed')
                            ->get();

        foreach ($overdueTasks as $task) {
            Mail::to($task->assignedTo->email)->send(new OverdueTaskReminder($task));
            
            $this->info('Reminder sent for task: ' . $task->title);
        }

        $this->info('Overdue task reminder check completed.');
    }
}
