<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Exports\TasksExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{        
    
    public function index()
    {
        if (!Gate::allows('viewAny', Task::class)) {
            return response()->json(['message' => 'Access Denied'], 403);
        }

        $tasks = Task::with('comments', 'comments.user','createdBy', 'assignedTo')->get();
        return response()->json(['tasks' => $tasks], 200);
    }

    public function myTasks()
    {
        $tasks = Task::where('assigned_to', auth()->id())->with('comments', 'createdBy', 'assignedTo')->get();

        return response()->json([
            'tasks' => $tasks
        ], 200);
    }

    public function show(Task $task)
    {
        if (!$task || !Gate::allows('view', $task)) {
            return response()->json(['message' => 'Access Denied'], 403);
        }

        return response()->json(['task' => $task], 200);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('create', Task::class)) {
            return response()->json(['message' => 'Access Denied'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth()->id(),
            'due_date' => $request->due_date,
            'priority' => $request->priority,
        ]);

        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }

    public function update(Request $request, Task $task)
    {
        if (!$task || !Gate::allows('update', $task)) {
            return response()->json(['message' => 'Access Denied'], 403);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'status' => 'sometimes|required|in:pending,in_progress,completed',
            'due_date' => 'sometimes|nullable|date',
            'priority' => 'sometimes|required|in:low,medium,high',
        ]);

        $task->update($request->all());

        return response()->json(['message' => 'Task updated successfully', 'task' => $task], 200);
    }

    public function destroy(Task $task)
    {
        if (!$task || !Gate::allows('delete', $task)) {
            return response()->json(['message' => 'Access Denied'], 403);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully'], 200);
    }

    public function export(Request $request, $format)
    {
        if (!Gate::allows('export', Task::class)) {
            return response()->json(['error' => 'Unauthorized. Only admins can export.'], 403);
        }
        $fileName = 'tasks_' . now()->format('Y-m-d_H-i-s') . '.' . $format;
        $filePath = "exports/" . $fileName;

        // Store the file in storage/app/public/exports
        Excel::store(new TasksExport, $filePath, 'public');

        // Generate the download link
        $downloadUrl = Storage::url($filePath);

        return response()->json([
            'message' => 'Export successful',
            'download_url' => url($downloadUrl)
        ]);
    }
}
