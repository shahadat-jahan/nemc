<?php

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassRoutine;
use App\Models\Subject;
use App\Models\Department;
use App\Models\Attencance;
use Illuminate\Support\Facades\Auth;

function checkEmpty($value){

    return isset($value) ? (!empty($value) ? $value : null) : null;
}

function getAvatar($gender = 'male'){
    return ($gender == 'male') ? asset('assets/global/img/male_avater.png') : asset('assets/global/img/female_avater.png');
}

function getAppPrefix(){
    return str_replace('/', '', Route::current()->getPrefix());
}

function customRoute($name){
    if (getAppPrefix() == 'nemc'){
        $name = 'frontend.'.$name;
    }

    return $name;
}

function formatAmount($amount, $decimal = 2){
    return number_format($amount, $decimal,".",",");
}

function groupDatesByDay(array $dates) {
    $groupedDates = [];

    foreach ($dates as $date) {
        $carbonDate = Carbon::createFromFormat('Y-m-d', $date);
        $dayOfWeek = $carbonDate->format('l');

        if (!isset($groupedDates[$dayOfWeek])) {
            $groupedDates[$dayOfWeek] = $date;
        }
    }

    return array_keys($groupedDates);
}

function generateDatesByDay($day, $date1, $date2){
    $allDays = [];
    if ($day == 1){
        $selectedDay = Carbon::SATURDAY;
    }elseif ($day == 2){
        $selectedDay = Carbon::SUNDAY;
    }elseif ($day == 3){
        $selectedDay = Carbon::MONDAY;
    }elseif ($day == 4){
        $selectedDay = Carbon::TUESDAY;
    }elseif ($day == 5){
        $selectedDay = Carbon::WEDNESDAY;
    }elseif ($day == 6){
        $selectedDay = Carbon::THURSDAY;
    }else{
        $selectedDay = Carbon::FRIDAY;
    }

    /*$startDate = Carbon::parse($date1)->next($selectedDay);
    $endDate = Carbon::parse($date2);*/

    $startDate = Carbon::createFromFormat('d/m/Y', $date1)->next($selectedDay);
    $endDate = Carbon::createFromFormat('d/m/Y', $date2);

    for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
        $allDays[] = $date->format('Y-m-d');
    }

    return $allDays;

}

function parseClassTime($time){
    return Carbon::createFromFormat('H:i:s', $time)->format('H:i');
}
function parseClassTimeInTwelveHours($time){
    return Carbon::createFromFormat('H:i:s', $time)->format('g:i A');
}

function addMinute($time, $minute = 1){
    return Carbon::createFromFormat('H:i', $time)->addMinutes($minute)->format('H:i');
}

function getDayName($date){
    return Carbon::parse($date)->format('l');
}

function getDayYear($date){
    return Carbon::parse($date)->format('Y');
}

function ordinalNumber($number){
    $ordinalNumber = new \NumberFormatter('en_US', \NumberFormatter::ORDINAL);

    return $ordinalNumber->format($number);
}

function getOrdinal($number){
    // get first digit
    $digit = abs($number) % 10;
    $ext = 'th';
    // if the last two digits are between 4 and 21 add a th
    if(abs($number) %100 < 21 && abs($number) %100 > 4){
        $ext = 'th';
    }else{
        if($digit < 4){
            $ext = 'rd';
        }
        if($digit < 3){
            $ext = 'nd';
        }
        if($digit < 2){
            $ext = 'st';
        }
        if($digit < 1){
            $ext = 'th';
        }
    }
    return $number.$ext;
}

function arrayKeyFirst(array $array)
{
    return $array ? array_keys($array)[0] : null;
}

function getStudentsIdByParentId($parentId){
    return Student::where('parent_id', $parentId)->pluck('id')->toArray();
}

function getTeacherNameByTeacherId($techerId){
    return Teacher::where('id', $techerId)->select('first_name','last_name')->first();
}

function getSubjectsIdByTeacherId($teacherId, $courseId){

    $query = Subject::whereHas('department.teachers', function ($q) use ($teacherId){
        $q->where('id', $teacherId);
    });

    if (!empty($courseId)){
        $query = $query->whereHas('subjectGroup', function ($q) use ($courseId){
            $q->where('course_id', $courseId);
        });
    }

    $subjects = $query->pluck('id')->toArray();

    return $subjects;
}
function getSubjectsIdByCourseId($courseId){
    $query = Subject::whereHas('subjectGroup', function ($q) use ($courseId){
        $q->where('course_id', $courseId);
    });
    $subjects = $query->pluck('id')->toArray();

    return $subjects;
}

function getDepartmentIdByTeacherId($teacherId, $courseId){

    $query = Department::whereHas('teachers', function ($q) use ($teacherId){
        $q->where('id', $teacherId);
    });

    if (!empty($courseId)){
        $query = $query->whereHas('subjects.subjectGroup', function ($q) use ($courseId){
            $q->where('course_id', $courseId);
        });
    }

    $departments = $query->pluck('id')->toArray();

    return $departments;
}

function getMonthListFromDate($startYear, $startMonth, $endYear, $endMonth){
    if ($endMonth == 1){
        $endYear = $endYear - 1;
        $endMonth = 12;
    }
    $start    = Carbon::create($startYear, $startMonth, 1);
    $end      = Carbon::create($endYear, $endMonth, 1);

    $period = \Carbon\CarbonInterval::month()->toPeriod($start, $end);

    $months = [];
    $years = [];

    foreach ($period as $dt) {
        $months[] = $dt->format("m");
        $years[] = $dt->format("Y");
    }

    return ['years' => $years, 'months' => $months];
}

function formatDate($date, $format = 'Y-m-d'){

    return Carbon::parse($date)->format($format);
}

function getSubjectsIdByDepartmentIdAndCourseId($departmentId, $courseId){

    $query = Subject::where('department_id', $departmentId);

    if (!empty($courseId)){
        $query = $query->whereHas('subjectGroup', function ($q) use ($courseId){
            $q->where('course_id', $courseId);
        });
    }

    $subjects = $query->pluck('id')->toArray();

    return $subjects;
}

function getTotalClass($teacher_id, $sessionId = '', $phaseId = '', $termId = '', $subjectId = '', $classTypeId = null, $notIn = false, $fromDate = '', $toDate = '', $courseId = '')
{
   $query = ClassRoutine::has('attendances')
           ->where('teacher_id', $teacher_id);
        if (!empty($sessionId)){
            $query = $query->where('session_id', $sessionId);
        }
        if (!empty($courseId)){
            $query = $query->where('course_id', $courseId);
        }
        if (!empty($phaseId)){
            $query = $query->where('phase_id', $phaseId);
        }
        if (!empty($termId)){
            $query = $query->where('term_id', $termId);
        }
        if (!empty($subjectId)){
            $query = $query->where('subject_id', $subjectId);
        }

    if (!empty($classTypeId)) {
            if ($notIn == true){
                $query = $query->whereNotIn('class_type_id', [$classTypeId]);
            }else{
                $query = $query->whereIn('class_type_id', [$classTypeId]);
            }
        }

        if (!empty($fromDate) && !empty($toDate)){
            $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
            $toDate = Carbon::createFromFormat('d/m/Y', $toDate)->format('Y-m-d');
            $query = $query->whereBetween('class_date',[$fromDate, $toDate]);
        }elseif(!empty($fromDate)){
            $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
           $query = $query->whereDate('class_date', '=',$fromDate);
        }elseif(!empty($toDate)){
          $toDate = Carbon::createFromFormat('d/m/Y', $toDate)->format('Y-m-d');
           $query = $query->whereDate('class_date', '=',$toDate);
        }

   return $query->count();
}

function getAttaendClass($id){
    $result=Attencance::where('class_routine_id',$id)->count();
    if(!empty($result)){
        return "Yes";
    }

    return "No";
}

function isEvening($time = null): bool
{
    if (empty($time)) {
        return false;
    }

    $time        = Carbon::createFromFormat('H:i', $time);
    $eveningTime = Carbon::createFromFormat('H:i', '15:00'); //3:00 PM

    return ($time >= $eveningTime);
}

/**
 * Check if current user can suspend a class
 * Allowed users: Super Admin (1), Subject Teacher (4), Teacher with extra role (11), Department Head/HOD (12)
 * Optimized: Caches user data to avoid repeated lookups
 *
 * @param $classRoutine ClassRoutine model
 *
 * @return bool
 */
function canUserEditClass(ClassRoutine $classRoutine): bool
{
    if (!Auth::guard('web')->check()) {
        return false;
    }

    $user        = Auth::guard('web')->user();
    $userGroupId = $user->user_group_id;

    // Super Admin can suspend any class
    if ($userGroupId == 1) {
        return true;
    }

    // Subject Teacher or Teacher with extra role (4, 11)
    if (in_array($userGroupId, [4, 11])) {
        $teacherId = $user->teacher->id ?? null;
        if (!$teacherId) {
            return false;
        }

        // Lecture or revised class - direct comparison (faster)
        if ($classRoutine->class_type_id == 1 || $classRoutine->class_type_id == 9 ||
            $classRoutine->class_type_id == 17) {
            return $classRoutine->teacher_id == $teacherId;
        }

        // Practical class - check if teacher in student group
        return $classRoutine->studentGroupTeacher()
                            ->whereKey($teacherId)
                            ->exists();
    }

    // Department Head/HOD (12)
    if ($userGroupId == 12) {
        return $classRoutine->subject->department->teacher->user_id == $user->id;
    }

    return false;
}
