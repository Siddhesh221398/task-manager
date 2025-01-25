<!-- resources/views/emails/task_assigned.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Assigned</title>
</head>
<body>
    <h1>You have been assigned a new task</h1>
    <p>Task Name: {{ $task->title }}</p>
    <p>Task Description: {{ $task->description }}</p>
    <p>Assigned By: {{ $task->createdBy->name }}</p>
</body>
</html>
