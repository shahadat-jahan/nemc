<?php
/**
 * Created by PhpStorm.
 * User: office
 * Date: 2/12/19
 * Time: 5:27 PM
 */

namespace App\Services\Admin;

use App\Models\Guardian;
use App\Models\User;
use App\Services\BaseService;
use App\Services\EmailService;
use Carbon\Carbon;
use DataTables;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuardianService extends BaseService
{

    protected $user;
    protected $userService;
    protected $emailService;

    public function __construct(Guardian $guardian, User $user, UserService $userService, EmailService $emailService)
    {
        $this->model        = $guardian;
        $this->user         = $user;
        $this->userService  = $userService;
        $this->emailService = $emailService;
    }

    public function getGuardianInfoByStudentId($studentId)
    {
        return $this->model->whereHas('students', function ($q) use ($studentId) {
            $q->where('id', $studentId);
        })->first();
    }

    public function updateParentInfo($request, $id)
    {
        $parentInfo = $this->find($id);

        $parentInfo->update([
            'father_name'              => $request->father_name,
            'mother_name'              => $request->mother_name,
            'father_phone'             => $request->father_phone,
            'mother_phone'             => checkEmpty($request->mother_phone),
            'father_email'             => checkEmpty($request->father_email),
            'mother_email'             => checkEmpty($request->mother_email),
            'address'                  => checkEmpty($request->parent_address),
            'occupation'               => checkEmpty($request->occupation),
            'annual_income'            => checkEmpty($request->annual_income),
            'annual_income_grade'      => checkEmpty($request->annual_income_grade),
            'movable_property'         => checkEmpty($request->movable_property),
            'movable_property_grade'   => checkEmpty($request->movable_property_grade),
            'immovable_property'       => checkEmpty($request->immovable_property),
            'immovable_property_grade' => checkEmpty($request->immovable_property_grade),
            'total_asset'              => checkEmpty($request->total_asset),
            'total_asset_grade'        => checkEmpty($request->total_asset_grade),
            'finance_during_study'     => $request->finance_during_study,
        ]);

        $parentInfo->user()->update([
            'email' => $request->father_email,
        ]);
        return $parentInfo;
    }

    public function changePassword($request, $id)
    {
        $guardian = $this->find($id);
        try {
            $guardian->user->update([
                'password' => Hash::make($request->new_password)
            ]);

            $user    = User::where('id', $guardian->user_id)->first();
            $student = $guardian->students()->first();

            //send sms & email
            if ($guardian->father_email) {
                $guardianPasswordMailBody =
                    '<table>
                        <tr>
                            <td>Dear ' . $guardian->father_name . ',</td>
                        </tr>
                        <tr>
                            <td>Your Password has been reset </td>
                        </tr>
                        <tr>
                            <td>URL: ' . url('/login') . ' </td>
                        </tr>
                        <tr>
                            <td>User ID: ' . $user->user_id . ' </td>
                        </tr>
                        <tr>
                            <td>Password: ' . $request->new_password . ' </td>
                        </tr>
                    <table>';
                $this->emailService->mailSend($guardian->father_email, '', 'NEMC: Guardian Password', 'password_reset', $guardianPasswordMailBody, '', $user);
            }

            if ($student->category_id != 2 && $student->nationality == 18 && $guardian->father_phone) {
                $client   = new Client();
                $massage  = "Dear " . $guardian->father_name . ", Your Password has been reset. URL: " . url('/login') . ", User ID: " . $user->user_id . ", Password: " . $request->new_password . ".";
                $data     = $client->post('https://gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2', [
                    'json' => [
                        "username"    => "NEMPLdt058",
                        "password"    => "Nemc@1998",
                        "apicode"     => "1",
                        "msisdn"      => $guardian->father_phone,
                        "countrycode" => "880",
                        "cli"         => "NEMC",
                        "messagetype" => "1",
                        "message"     => $massage,
                        "messageid"   => "0",
                    ]
                ]);
                $response = $data->getBody()->getContents();
                $response = json_decode($response);

                if ($response) {
                    DB::table('email_sms_histories')->insertGetId(
                        [
                            'user_id'       => $guardian->user_id,
                            'user_group_id' => $user->user_group_id,
                            'message_type'  => 'sms',
                            'purpose'       => 'password_reset',
                            'message'       => $massage,
                            'email'         => null,
                            'phone'         => $guardian->father_phone,
                            'response'      => json_encode($response),
                            'created_by'    => Auth::user()->id,
                            'created_at'    => Carbon::now(),
                            'updated_at'    => Carbon::now()
                        ]
                    );
                }
            }

            return $guardian;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function getDataTable($request)
    {
        $query = $this->model->with('user')->select();

        if (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            if ($user->student) {
                $query = $query->where('id', $user->student->parent_id);
            } else {
                $query = $query->where('id', $user->parent->id);
            }
        }

        return Datatables::of($query)
                         ->addColumn('user_id', function ($row) {
                             return $row->user->user_id;
                         })
                         ->addColumn('student', function ($row) {
                             $studentNames = [];
                             if ($row->students) {
                                 foreach ($row->students as $key => $student) {
                                     $studentNames[] = $student->full_name_en;
                                 }
                             }
                             return $studentNames;
                         })
                         ->addColumn('action', function ($row) {
                             $actions = '';
                             if (hasPermission('guardians/password')) {
                                 if (getAppPrefix() == 'admin') {
                                     $actions .= '<a href="' . route('guardian.password-change.form', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Change Password"><i class="fa fa-key"></i></a>';
                                 } else {
                                     $actions .= '<a href="' . route('frontend.guardian.password-change.form', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Change Password"><i class="fa fa-key"></i></a>';
                                 }
                             }
                             if (hasPermission('guardians/edit')) {
                                 $actions .= '<a href="' . route('guardians.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                             }

                             if (getAppPrefix() == 'admin') {
                                 $actions .= '<a href="' . route('guardians.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                             } else {
                                 $actions .= '<a href="' . route('frontend.guardians.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                             }

                             if (Auth::guard('student_parent')->check()) {
                                 $user = Auth::guard('student_parent')->user();
                                 if ($user->student) {
                                     if ($user->student->id == $row->id) {
                                         $actions .= '';
                                     }
                                 }
                             } else {
                                 $actions .= '<a href="javascript:void(0)" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill send-message-user" data-message-to-user-id="' . $row->user->id . '" title="Send Message to Parents"><i class="fas fa-envelope"></i></a>';
                             }

                             return $actions;
                         })
                         ->rawColumns(['student', 'action'])
                         ->filter(function ($query) use ($request) {
                             if (!empty($request->session_id)) {
                                 $query->whereHas('students', function ($q) use ($request) {
                                     return $q->where('session_id', $request->session_id);
                                 });
                             }
                             if (!empty($request->course_id)) {
                                 $query->whereHas('students', function ($q) use ($request) {
                                     return $q->where('course_id', $request->course_id);
                                 });
                             }

                             if (!empty($request->student_id)) {
                                 $query->whereHas('students', function ($q) use ($request) {
                                     return $q->where('id', $request->student_id);
                                 });
                             }

                             if (!empty($request->get('phone'))) {
                                 $query->where('father_phone', $request->get('phone'));
                             }

                             if (!empty($request->get('name'))) {
                                 $query->where('father_name', 'like', '%'.$request->get('name').'%')
                                 ->orWhere('mother_name', 'like', '%'.$request->get('name').'%');
                             }
                         })
                         ->make(true);
    }

    public function addParentInfo($request)
    {
        // check parent exist
        $guardian = $this->getGuardianInfoByUserId($request->father_user_id);

        if (empty($guardian)) {
            // add parent user
            $parentUser = $this->userService->create([
                'user_group_id' => 6,
                'email'         => checkEmpty($request->father_email),
                'user_id'       => 'pr' . $request->user_id,
                'password'      => $request->father_password,
            ]);

            //parents info
            $parentsData = [
                'user_id'                  => $parentUser->id,
                'father_name'              => $request->father_name,
                'mother_name'              => $request->mother_name,
                'father_phone'             => checkEmpty($request->father_phone),
                'mother_phone'             => checkEmpty($request->mother_phone),
                'father_email'             => checkEmpty($request->father_email),
                'mother_email'             => checkEmpty($request->mother_email),
                'address'                  => checkEmpty($request->parent_address),
                'occupation'               => checkEmpty($request->occupation),
                'annual_income'            => checkEmpty($request->annual_income),
                'annual_income_grade'      => checkEmpty($request->annual_income_grade),
                'movable_property'         => checkEmpty($request->movable_property),
                'movable_property_grade'   => checkEmpty($request->movable_property_grade),
                'immovable_property'       => checkEmpty($request->immovable_property),
                'immovable_property_grade' => checkEmpty($request->immovable_property_grade),
                'total_asset'              => checkEmpty($request->total_asset),
                'total_asset_grade'        => checkEmpty($request->total_asset_grade),
                'finance_during_study'     => $request->finance_during_study,
            ];

            $parentUser->parent()->create($parentsData);

            $guardianInfo = $parentUser->parent;

            return $guardianInfo;
        }
    }

    public function getGuardianInfoByUserId($userId)
    {
        return $this->model->whereHas('user', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->first();
    }

    public function getParentId($userId)
    {
        return $this->model->where('user_id', $userId)->first()->id;
    }

    // parent list
    public function getParentList($request)
    {
        $parents = $this->model->with('students.session', 'students.course', 'students.phase', 'students.studentCategory', 'user')->whereHas('students', function (Builder $query) use ($request) {
            $query->where([
                ['followed_by_session_id', $request->session_id],
                ['course_id', $request->course_id]
            ])->orderBy('roll_no');
        });

        if (!empty($request->student_category_id)) {
            $parents = $parents->whereHas('students', function (Builder $query) use ($request) {
                $query->where('student_category_id', $request->student_category_id);
            });
        }
        if (!empty($request->phase_id)) {
            $parents = $parents->whereHas('students', function (Builder $query) use ($request) {
                $query->where('phase_id', $request->phase_id);
            });
        }

        //return $parents->get();
        return $parents = $parents->get()
            //sort by student roll no
                                  ->sortBy(function ($value, $key) use ($request) {
                return $value->students->where('followed_by_session_id', $request->session_id)->where('course_id', $request->course_id)->first()->roll_no;
            });
    }
}
