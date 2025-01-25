<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TasksExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Task::select('id', 'title', 'status', 'priority', 'assigned_to', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Title', 'Status', 'Priority', 'Assigned To', 'Created At'];
    }
}
