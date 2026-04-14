<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\Admin\CourseService;
use App\Services\Admin\GuardianService;
use App\Services\Admin\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GuardianController extends Controller
{

    /**
     *
     */
    const moduleName = 'Parent Management';
    /**
     *
     */
    const redirectUrl = 'admin/guardians';
    /**
     *
     */
    const moduleDirectory = 'guardians.';

    protected $service;
    protected $sessionService;
    protected $courseService;

    public function __construct(GuardianService $service, SessionService $sessionService, CourseService $courseService)
    {
        $this->service = $service;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [
            'pageTitle' => 'Parents',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'session_id' => $request->input('session_id'),
            'course_id' => $request->input('course_id'),
            'student_id' => $request->input('student_id'),
            'tableHeads' => ['User ID', 'Student', 'Father Name', 'Mother Name', 'Father Phone', 'Action'],
            'dataUrl' => self::redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'user_id', 'name' => 'user_id'],
                ['data' => 'student', 'name' => 'student'],
                ['data' => 'father_name', 'name' => 'father_name'],
                ['data' => 'mother_name', 'name' => 'mother_name'],
                ['data' => 'father_phone', 'name' => 'father_phone'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ]
        ];

        return view(self::moduleDirectory.'index', $data);
    }

    public function getData(Request $request){
        return $this->service->getDataTable($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'pageTitle' => 'Parents',
            'parentInfo' => $this->service->find($id),
        ];

        return view(self::moduleDirectory.'view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'pageTitle' => 'Parents',
            'parentInfo' => $this->service->find($id),
        ];

        return view(self::moduleDirectory.'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->student_category_id != 2){
            $validator = Validator::make($request->all(), [
                'father_phone' => 'required|regex:/^(?=.*[1-9])[0-9]{11}$/|unique:guardians,father_phone,' . $id
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'father_phone' => 'required|regex:/^\+\d{1,3}(?:[-.\s]?\(?\d{1,4}\)?)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/|unique:guardians,father_phone,' . $id
            ]);
        }

        if ($validator->fails()) {
            $request->session()->flash('error', 'Please check father phone number');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $parentInfo = $this->service->updateParentInfo($request, $id);

        if ($parentInfo){
            $request->session()->flash('success', setMessage('update', 'Parents'));
            return redirect()->route('guardians.index');
        }

        $request->session()->flash('error', setMessage('update.error', 'Parents'));
        return redirect()->route('guardians.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guardian $guardian)
    {
        //
    }

    public function getInfoByUserId(Request $request){
        if ($request->has('userId')) {
            $userId = $request->input('userId');

            $guardian = $this->service->getGuardianInfoByUserId($userId);

            if (!empty($guardian)){
                return response()->json(['status' => true, 'data' => $guardian]);
            }else{
                return response()->json(['status' => false, 'data' => []]);
            }

        }

    }

    public function changePasswordForm($id){
        $data = [
            'pageTitle' => 'Parents',
            'parentId' => $id,
        ];

        return view(self::moduleDirectory.'change_password', $data);
    }

    public function changePassword(Request $request, $id){
        $changePassword = $this->service->changePassword($request, $id);

        if ($changePassword){
            $request->session()->flash('success', setMessage('update', 'Password'));
            return redirect()->route('guardians.index');
        }

        $request->session()->flash('error', setMessage('update.error', 'Password'));
        return redirect()->route('guardians.index');
    }

    public function sendTestSMS(Request $request, $id) {
        //dd('hello');
        $client = new \GuzzleHttp\Client();
        $message = sprintf('Dear Parents, %sThis is for your kind information that, North East Medical College will soon launch a sms service to enhance students attendance. If any student is absent, you\'ll receive an automatic notification. %s%sStay updated on your student\'s attendance effortlessly. Your engagement is crucial for their progress. %sThank you %sPrincipal %sNEMC', PHP_EOL, PHP_EOL, PHP_EOL, PHP_EOL, PHP_EOL, PHP_EOL);
        dd($message);
        //dd($guardian->father_phone);
        $teachers = [
            '01912969336', '01711700586', '01712788318', '01786511305', '01720377791', '01730300664', '01746867056', '01521461087', '01681788115',
            '01723236362', '01716247914', '01798243791', '01738988957', '01749745756', '01300246100', '01670284634',
            '01682246480', '01684049783', '01688818352', '01700643834', '01701178669', '01703451823', '01711059790',
            '01711973111', '01712623077', '01712651341', '01713459223', '01716888154', '01717497395', '01717932000',
            '01718502724', '01720979397', '01730658341', '01734003959', '01738234055', '01911938566', '01798599459'
        ];

//        dd($teachers[2]);

        foreach ($teachers as $teacher) {
            $data = $client->post('https://gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2', [
                'json' => [
                    "username" => "NEMPLdt058",
//                    "password" => "Nemc@1998",
                    "password" => "Nemc@199",
                    "apicode" => "1",
                    "msisdn" => $teacher,
                    "countrycode" => "880",
                    "cli" => "NEMC",
                    "messagetype" => "1",
                    "message" => $message,
                    "messageid" => "0",
                ]
            ]);
            $response = $data->getBody()->getContents();
            $response = json_decode($response);

//            $queuedData = DB::table('campaign_logs')->insertGetId(
//                array(
//                    'campaign_type' => 'SMS',
//                    'message' => $message,
//                    'mobile_number' => $teacher,
//                    'receiver_id' => '',
//                    'receiver_type' => 'Teacher',
//                    'created_by' => Auth::user()->id,
//                    'created_at' => Carbon::now(),
//                    'updated_at' => Carbon::now(),
//                )
//            );
        }





        $allGuardians = Student::whereIn('session_id', [1,2,5,6])->where('student_category_id', 1)->get();
//        dd($allGuardians);
        foreach ($allGuardians as $guardian) {
            $data = $client->post('https://gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2', [
                'json' => [
                    "username" => "NEMPLdt058",
//                    "password" => "Nemc@1998",
                    "password" => "Nemc@199",
                    "apicode" => "1",
                    "msisdn" => $guardian->parent->father_phone,
                    "countrycode" => "880",
                    "cli" => "NEMC",
                    "messagetype" => "1",
                    "message" => $message,
                    "messageid" => "0",
                ]
            ]);
            $response = $data->getBody()->getContents();
            $response = json_decode($response);

//            $queuedData = DB::table('campaign_logs')->insertGetId(
//                array(
//                    'campaign_type' => 'SMS',
//                    'message' => $message,
//                    'mobile_number' => $guardian->parent->father_phone,
//                    'receiver_id' => $guardian->id,
//                    'receiver_type' => 'Guardian',
//                    'created_by' => Auth::user()->id,
//                    'created_at' => Carbon::now(),
//                    'updated_at' => Carbon::now(),
//                )
//            );
        }

        dd('done');
        $request->session()->flash('success', setMessage('create', 'Message'));
        return redirect()->back();
    }
}
