<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index() {
        $students = Student::query()->where('session_id', 5)->where('course_id', 1)->where('phase_id', 3)->pluck('roll_no')->toArray();
        $arr2 = range(1,max($students));
        $missing = array_diff($arr2, $students);
        dd($students, $arr2, $missing);
    }

    public function emailPhone() {
        $students = Student::where('status', 1)->get();
        $count = 1;
        foreach ($students as $student) {
            if ($student->mobile && $student->email) {
                continue;
            } else {
                echo $count++ . '. ' . $student->full_name_en . ' ' . $student->session->title . ' ' . $student->mobile . ' ' . $student->email;
                echo '<br>';
            }
        }
        dd($students[0]->parent);
    }
}
