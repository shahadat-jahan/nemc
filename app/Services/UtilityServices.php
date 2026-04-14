<?php

/**
 * Created by PhpStorm.
 * User: office
 * Date: 11/5/18
 * Time: 2:54 PM
 */

namespace App\Services;

/**
 * Class UtilityServices
 * @package App\Services
 */
class UtilityServices
{

    public static $certificates = [1 => 'SSC / O Level / Similar', 'HSC / A Level / Similar'];

    public static $admissionStatus = [1 => 'Pending', 'Waiting List', 'Selected for admission'];

    public static $ClassDays = [1 => 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    public static $months = [
        1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
        'November', 'December'
    ];

    public static $studentGroupTypes = [1 => 'Class & Exam', 'Visit', 'Clinical & Practical', 'Ward'];

    public static $passStatus = [1 => 'Pass', 'Fail', 'Pass(grace)', 'Absent'];

    public static $smsEmailPurposes = [
        'attendance'     => 'Attendance',
        'password_reset' => 'Password Reset',
        'result'         => 'Result',
        'new_account'    => 'New Account',
        'fee'            => 'Fee',
        'admission'      => 'Admission',
        'notification'   => 'Notification',
        'low_attendance' => 'Low Attendance',
        'other'          => 'Other',
    ];

    public static function getYears($limit = 20)
    {
        $yeas = [];
        for ($i = (date('Y') - $limit); $i <= (date('Y') + $limit); $i++) {
            $yeas[$i] = $i;
        }

        return $yeas;
    }

    public static function getFloors()
    {
        return self::_makeFloors();
    }

    public static function _makeFloors()
    {
        $floors = ['Ground Floor'];
        foreach (range(1, 10) as $key => $number) {
            $floors[$key + 1] = 'Floor ' . $number;
        }

        return $floors;
    }

    public static $notificationModels = [
        1 => 'App\Models\NoticeBoard',
        'App\Models\Holiday',
        'App\Models\Message',
        'App\Models\ExamResult'
    ];

    /*public static $chartColors =[
        'green' => [
            'radialGradient' => ['cx'=> 0.8, 'cy' =>  0.8, 'r' => 0.8],
            'stops'=> [[0, '#dce35b'], [1, '#45b649']]
        ],
        'red' => [
            'radialGradient' => ['cx'=> 0.8, 'cy' =>  0.8, 'r' => 0.8],
            'stops'=> [[0, '#3e5151'], [1, '#decba4']]
        ],
    ];*/

    public static $chartColors = [
        'green'  => 'rgb(66, 183, 42)',
        'red'    => '#db1430',
        'paste'  => '#34bfa3',
        'gray'   => '#6c757d',
        'orange' => '#ffc107',

    ];

    public static $studentStatus = [1 => 'Active', 'Inactive', 'In-leave', 'Suspend', 'Complete Degree'];

    public static $evaluationStatements = [
        1 => "Starts class by capturing students' attention",
        2 => "Clearly states learning objectives at the start",
        3 => "Checks students' prior knowledge",
        4 => "Manages class time effectively",
        5 => "Speaks clearly and understandably",
        6 => "Uses effective teaching aids/materials",
        7 => "Encourages student participation",
        8 => "Summarizes key points at the end",
        9 => "Provides helpful references for study",
        10 => "Assesses student understanding during class",
        11 => "Creates a supportive learning environment",
        12 => "Motivates students to learn",
        13 => "Respects students' opinions",
        14 => "Is approachable for help or questions",
        15 => "Promotes a positive academic atmosphere"
    ];
}
