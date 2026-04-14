<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportToExcelFromArray;
use App\Http\Controllers\Controller;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportExportController extends Controller
{
    public function localStudentMobileEmailExport() {
        $fileName = 'Local Student Mobile Email List';
        $data = [];
        $count = 1;
        $localStudents = Student::whereIn('session_id', [5,6,7])->where('student_category_id', '!=', 2)->where('status', 1)->get();

        foreach ($localStudents as $localStudent) {
            $studentMobile = 'ok';
            $studentEmail = 'ok';
            $fatherMobile = 'ok';
            $fatherEmail = 'ok';
            if (strlen($localStudent->mobile) != 11 || !filter_var($localStudent->email, FILTER_VALIDATE_EMAIL)
                    || strlen($localStudent->parent->father_phone) != 11 || !filter_var($localStudent->parent->father_email, FILTER_VALIDATE_EMAIL)) {
                $data[] = [
                    'Session' => $localStudent->session->title,
                    'Student Name' => $localStudent->full_name_en,
                    'Student Roll' => $localStudent->roll_no,
//                    'Student Mobile' => $localStudent->mobile,
//                    'Student Email' => $localStudent->email,
//                    'Parent Mobile' => $localStudent->parent->father_phone,
//                    'Parent Email' => $localStudent->parent->father_email,
                ];
            }


//            if (strlen($localStudent->mobile) != 11) {
//                $studentMobile = $localStudent->mobile;
//            }
//            if (!filter_var($localStudent->email, FILTER_VALIDATE_EMAIL)) {
//                $studentEmail = $localStudent->email;
//            }
//            if (strlen($localStudent->parent->father_phone) != 11) {
//                $fatherMobile = $localStudent->parent->father_phone;
//            }
//            if (!filter_var($localStudent->parent->father_email, FILTER_VALIDATE_EMAIL)) {
//                $fatherEmail = $localStudent->parent->father_email;
//            }
//
//            $data[] = [
//                'Session' => $localStudent->session->title,
//                'Student Name' => $localStudent->full_name_en,
//                'Student Roll' => $localStudent->roll_no,
//                'Student Mobile' => $studentMobile,
//                'Student Email' => $studentEmail,
//                'Parent Mobile' => $fatherMobile,
//                'Parent Email' => $fatherEmail,
//            ];


        }

        $headings = ['Session', 'Student Name', 'Student Roll'];
        //$headings = ['Session', 'Student Name', 'Student Roll', 'Student Mobile', 'Student Email', 'Parent Mobile', 'Parent Email'];
        return  Excel::download(new ExportToExcelFromArray($headings, $data), $fileName . '.xlsx');
    }

    public function localStudentParentMobileEmailExport() {
        $fileName = 'Local Student Parent Mobile Email List';
        $data = [];
        $count = 1;
        $students = Student::whereIn('session_id', [5,6,7])->where('student_category_id', '!=', 2)->pluck('id')->toArray();
        $localStudentsGuardian = Guardian::with(['students', function ($q) use($students){
            $q->whereIn('id', function ($q) use($students) {
                $q->whereIn('id', $students);
            });
        }])->get();
        dd($localStudentsGuardian);
        foreach ($localStudents as $localStudent) {
            if (strlen($localStudent->mobile) != 11 || !filter_var($localStudent->email, FILTER_VALIDATE_EMAIL)) {
                $data[] = [
                    'Session' => $localStudent->session->title,
                    'Student Name' => $localStudent->full_name_en,
                    'Student Roll' => $localStudent->roll_no,
                    'Student Mobile' => $localStudent->mobile,
                    'Student Email' => $localStudent->email,
                    'Parent Mobile' => $localStudent->parent->father_phone,
                    'Parent Email' => $localStudent->parent->father_email,
                ];
            }
        }

        $headings = ['Session', 'Student Name', 'Student Roll', 'Student Mobile', 'Student Email', 'Parent Mobile', 'Parent Email'];
        return  Excel::download(new ExportToExcelFromArray($headings, $data), $fileName . '.xlsx');
    }
}
