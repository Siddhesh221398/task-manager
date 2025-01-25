<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('You have been assigned a new task: ' . $this->task->title)
                    ->line('Description: ' . $this->task->description)
                    ->line('Priority: ' . ucfirst($this->task->priority))
                    ->line('Due Date: ' . $this->task->due_date->format('Y-m-d H:i'))
                    ->action('View Task', url('/tasks/'.$this->task->id))
                    ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
