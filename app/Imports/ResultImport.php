<?php

namespace App\Imports;

use App\Services\ResultService;
use Exception;
use Setting;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class ResultImport implements ToCollection, WithHeadingRow
{
    protected $resultService;
    protected $request;
    public $info = [];

    public function __construct(Request $request, ResultService $resultService)
    {
        $this->request = $request;
        $this->resultService = $resultService;
    }

    public function collection(Collection $rows)
    {
        try {
            $passPercentage = Setting::getSiteSetting()->pass_mark;
            $insertedResultIds = [];

            foreach ($rows as $row) {
                $studentId = $row['id'];

                // Ensure student_id exists in sub_type_mark
                if (!isset($this->request->sub_type_mark[$studentId])) {
                    return $this->info = ['message' => 'Invalid student ID in file', 'status' => false];
                }

                // Extract expected subject IDs for this student
                $expectedSubjectIds = array_keys($this->request->sub_type_mark[$studentId]);

                // Extract all subject IDs from the file row
                $fileSubjectIds = [];
                foreach ($row as $key => $value) {
                    if (preg_match('/^\d+_/', $key)) {
                        [$examSubjectMarkId] = explode('_', $key);
                        $fileSubjectIds[] = $examSubjectMarkId;
                    }
                }

                // If there is any unmatched ID, reject the entire file
                if (array_diff($fileSubjectIds, $expectedSubjectIds) || array_diff($expectedSubjectIds, $fileSubjectIds)) {
                    return $this->info = [
                        'message' => 'Mismatch in subject mark IDs. Please check the file.', 'status' => false
                    ];
                }

                foreach ($row as $key => $value) {
                    if (preg_match('/^\d+_/', $key)) {
                        [$examSubjectMarkId] = explode('_', $key);
                        $mark = $value ?? null;
                        $passStatus = $this->resultService->getPassStatus($mark, $examSubjectMarkId, $passPercentage);

                        $studentMark = [
                            'student_id' => $studentId,
                            'exam_subject_mark_id' => $examSubjectMarkId,
                            'responsible_teacher_id' => data_get($this->request, 'teacher_id'),
                            'marks' => $mark,
                            'result_date' => Carbon::now()->format('d/m/Y'),
                            'pass_status' => $passStatus,
                            'remarks' => $row['comment'] ?? '',
                        ];

                        $examMarks = $this->resultService->create($studentMark);
                        if ($examMarks) {
                            $insertedResultIds[] = $examMarks->id;
                        }
                    }
                }
            }

            $this->resultService->processResult($insertedResultIds);
            return $this->info = ['message' => 'Result Excel Import Done', 'status' => true];
        } catch (Exception $e) {
            Log::error('Result Import Error: ' . $e->getMessage());
            return $this->info = ['message' => 'Error: ' . $e->getMessage(), 'status' => false];
        }
    }

}
