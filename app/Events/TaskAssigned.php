<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskAssigned implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;
   
    public function __construct(Task $task)
    {
        $this->task = $task;
    }
    
    public function broadcastOn()
    {        
        return new PrivateChannel('user.' . $this->task->user_id);
    }

    public function broadcastWith()
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'assigned_by' => $this->task->created_by,  
        ];
    }
}