<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\User;
use App\Mail\TaskAssignedMail;
use App\Events\TaskAssigned;
use Illuminate\Support\Facades\Mail;

class TaskObserver
{
    public function created(Task $task)
    {
        if ($task->assignedTo) {
            $this->sendTaskAssignedNotification($task);
        }
    }

    public function updated(Task $task)
    {        
        if ($task->isDirty('assigned_to')) {
            $this->sendTaskAssignedNotification($task);
        }
    }

    protected function sendTaskAssignedNotification(Task $task)
    {
       
        $user = $task->assignedTo;
        
        Mail::to($user->email)->send(new TaskAssignedMail($task));

        broadcast(new TaskAssigned($task));
    }
}
