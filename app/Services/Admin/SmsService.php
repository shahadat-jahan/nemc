<?php

namespace App\Services\Admin;

use App\Models\EmailSMSHistory;
use App\Models\User;
use App\Services\Admin\Admission\ClassRoutineService;
use App\Services\BaseService;
use App\Services\UtilityServices;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;
use Setting;

class SmsService extends BaseService
{
    protected $classRoutineService;
    protected $subjectService;
    protected $studentService;
    protected $model;

    public function __construct(ClassRoutineService $classRoutineService, SubjectService $subjectService, StudentService $studentService, EmailSMSHistory $emailSMSHistory)
    {
        $this->model = $emailSMSHistory;
        $this->subjectService = $subjectService;
        $this->studentService = $studentService;
        $this->classRoutineService = $classRoutineService;
    }

    public function getDataTable($request)
    {
        $query = $this->model->orderBy('created_at', 'desc')->select();
        return Datatables::of($query)
            ->editColumn('user_id', function ($row) {
                if (isset($row->receiver->teacher)) {
                    $receiver = $row->receiver->teacher->first_name . ' ' . $row->receiver->teacher->last_name;
                } elseif (isset($row->receiver->student)) {
                    $receiver = $row->receiver->student->full_name_en;
                }elseif (isset($row->receiver->parent)) {
                    $receiver = $row->receiver->parent->father_name;
                } elseif (isset($row->receiver->adminUser)) {
                    $receiver = $row->receiver->adminUser->full_name;
                }
                return $receiver ?? '';
            })
            ->addColumn('type_purpose', function ($row) {
                $type = $row->message_type;
                $purpose = UtilityServices::$smsEmailPurposes[$row->purpose] ?? $row->purpose;
                return trim(
                    ($type ? ucfirst($type) : '') .
                        ($type && $purpose ? ' – ' : '') .
                        ($purpose ? $purpose : '')
                );
            })
            ->addColumn('message', function ($row) {
                return strip_tags($row->message);
            })
            ->addColumn('email', function ($row) {
                return $row->email;
            })
            ->addColumn('phone', function ($row) {
                return $row->phone;
            })
            ->editColumn('response', function ($row) {
                if (is_null($row->message_type)) {
                    return '<span class="text-danger">' . $row->response . '</span>';
                }
                return $row->response;
            })
            ->editColumn('created_by', function ($row) {
                if (isset($row->sender->teacher)) {
                    $sender = $row->sender->teacher->first_name . ' ' . $row->sender->teacher->last_name;
                } elseif (isset($row->sender->adminUser)) {
                    $sender = $row->sender->adminUser->full_name;
                } else {
                    $sender = '';
                }
                return $sender;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->rawColumns(['response'])
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('sender_id'))) {
                    $query->where('created_by', $request->get('sender_id'));
                }
                if (!empty($request->get('message_type'))) {
                    $query->where('message_type', $request->get('message_type'));
                }
                if (!empty($request->get('purpose'))) {
                    $query->where('purpose', $request->get('purpose'));
                }
                if (!empty($request->get('start_date'))) {
                    $startDate = Carbon::createFromFormat('d/m/Y', $request->get('start_date'))->format('Y-m-d');
                    $query->whereDate('created_at', '>=', $startDate);
                }
                if (!empty($request->get('end_date'))) {
                    $endDate = Carbon::createFromFormat('d/m/Y', $request->get('end_date'))->format('Y-m-d');
                    $query->whereDate('created_at', '<=', $endDate);
                }
            })
            ->make(true);
    }

    public function sendSmsToParents()
    {
        $client = new \GuzzleHttp\Client();
        $showdata = [];
        $data = DB::select("SELECT * FROM `attencance` WHERE `attendance`=0 AND `send_sms`=0 AND `created_at` >= DATE_SUB(CURDATE(), INTERVAL 2 DAY)");

        if (!empty($data)) {
            foreach ($data as $value) {
                $routine = $this->classRoutineService->find($value->class_routine_id);
                $subject = $this->subjectService->find($routine->subject_id);
                $student = $this->studentService->getParentByStudentId($value->student_id);
                $showdata[$value->student_id][] = [
                    'id' => $value->id,
                    'student_id' => $value->student_id,
                    'full_name_en' => $student->full_name_en,
                    'father_name' => $student->parent->father_name,
                    'father_phone' => $student->parent->father_phone,
                    'admission_roll_no' => $student->admission_roll_no,
                    'created_at' => $value->created_at,
                    'class_routine_id' => $value->class_routine_id,
                    'topic_id' => $routine->topic_id,
                    'subject_id' => $subject->title,
                    'class_date' => $routine->class_date,
                    'start_from' => $routine->start_from,
                    'end_at' => $routine->end_at,
                ];
            }

            foreach ($showdata as $key => $Svalue) {
                $class_date = [];
                $subject_id = [];
                $id = [];
                foreach ($Svalue as $itam) {
                    $id[$itam['id']] = $itam['id'];
                    $student_id = $itam['student_id'];
                    $class_date[$itam['class_date']] = $itam['class_date'];
                    $full_name_en = $itam['full_name_en'];
                    $father_name = $itam['father_name'];
                    $father_phone = $itam['father_phone'];
                    $subject_id[$itam['subject_id']] = $itam['subject_id'];
                }

                $message = 'Dear Parents, records show Mark ' . $full_name_en . ' is absent ' . implode(',', array_values($class_date)) . ' and missing class "' . implode(',', array_values($subject_id)) . '", if you are unaware of this, please contact the office on "' . Setting::getSiteSetting()->phone . '".';


                $response = $client->post('https://gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2', [
                    'json' => [
                        "username" => "NEMPLdt058",
                        "password" => "Nemc@1998",
                        "apicode" => "1",
                        "msisdn" => $father_phone,
                        "countrycode" => "880",
                        "cli" => "NEMC",
                        "messagetype" => "1",
                        "message" => $message,
                        "messageid" => "0",
                    ]
                ]);

                if ($response) {
                    $data_update = [
                        'send_sms' => 1,
                    ];
                    DB::table('attencance')->whereIn('id', array_values($id))->update($data_update);

                    DB::table('sms_email_log')->insert(
                        array(
                            'student_id' => $student_id,
                            'message' => $message,
                            'class_date' => implode(',', array_values($class_date)),
                            'subject' => implode(',', array_values($subject_id)),
                            'status' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        )
                    );
                }
            }
            echo "successfully sms sent";
        } else {
            echo "no data found";
        }
    }

    /**
     * Get all unique senders (users who have sent SMS/Email).
     *
     * @return array [user_id => user_name]
     */
    public function getAllSender()
    {
        // Get all unique created_by values from the model (e.g., sms_email_log)
        $senderIds = $this->model
            ->whereNotNull('created_by')
            ->distinct()
            ->pluck('created_by')
            ->toArray();

        if (empty($senderIds)) {
            return [];
        }

        // Eager load possible relations for user name resolution
        $users = User::with(['adminUser', 'teacher'])
            ->whereIn('id', $senderIds)
            ->get();

        $userArray = [];
        foreach ($users as $user) {
            if ($user->teacher) {
                $userName = $user->teacher->full_name;
            } elseif ($user->adminUser) {
                $userName = $user->adminUser->full_name;
            } else {
                $userName = 'User #' . $user->id;
            }
            $userArray[$user->id] = $userName;
        }
        return $userArray;
    }
}
