<h1>Reminder: Task Overdue</h1>
<p>Dear {{ $task->assignedTo->name }},</p>
<p>We wanted to remind you that the following task is overdue:</p>
<p><strong>Task:</strong> {{ $task->title }}</p>
<p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}</p>
<p>Please take action on this task as soon as possible.</p>
