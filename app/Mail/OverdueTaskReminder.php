<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Task;

class OverdueTaskReminder extends Mailable
{
    use SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function build()
    {
        return $this->subject('Overdue Task Reminder')
                    ->view('emails.overdue_task_reminder');
    }
}
