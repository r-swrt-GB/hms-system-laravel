<?php
namespace App\Exports;

use App\Models\Assignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AssignmentMarksExport implements FromCollection, WithHeadings, WithMapping
{
    protected $assignment;

    public function __construct(Assignment $assignment)
    {
        $this->assignment = $assignment;
    }

    // Collection method to gather the data
    public function collection()
    {
        return $this->assignment->submissions()->with('user', 'comments')->get();
    }

    // Define the headings for the Excel file
    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Grade',
            'Comment Text',
        ];
    }

    // Map each row to the format required for the export
    public function map($submission): array
    {
        return [
            $submission->user->first()->first_name,
            $submission->user->first()->last_name,
            $submission->grade ?? 'Not Graded',
            $submission->comments->first()->comment_text ?? 'No Comments', // Get the comment text
        ];
    }
}
