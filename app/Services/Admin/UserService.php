<?php

namespace App\Services\Admin;

use App\Models\AdminUser;
use App\Models\User;
use App\Services\BaseService;
use App\Services\EmailService;
use Auth;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class UserService extends BaseService
{

    /**
     * @var $model
     */
    protected $model;
    protected $adminUserModel;
    protected $emailService;
    /**
     * @var string
     */
    protected $url = 'admin/users';

    /**
     * UserService constructor
     *
     * @param User $user
     */
    public function __construct(User $user, AdminUser $adminUser, EmailService $emailService)
    {
        $this->model          = $user;
        $this->adminUserModel = $adminUser;
        $this->emailService   = $emailService;
    }

    /**
     * @return JsonResponse
     */
    public function getAllData($request)
    {
        $query = $this->model->doesntHave('student')
                             ->doesntHave('teacher')
                             ->doesntHave('parent')
                             ->select();

        return Datatables::of($query)
                         ->addColumn('action', function ($row) {
                             $actions = '';
                             if (hasPermission('users/password')) {
                                 $actions .= '<a href="' . route('user.password-change.form', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Change Password"><i class="fa fa-key"></i></a>';
                             }
                             if (hasPermission('users/edit')) {
                                 $actions .= '<a href="' . url($this->url . '/' . $row->id . '/edit') . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="tooltip" title="Edit"><i class="flaticon-edit"></i></a>';
                             }
                             if (hasPermission('users/view')) {
                                 $actions .= '<a href="' . route('users.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="tooltip" title="View"><i class="flaticon-eye"></i></a>';
                             }
                             if (hasPermission('users/permission')) {
                                 $actions .= '<a href="' . route('admin.user.group.permission', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Permission"><i class="flaticon-cogwheel-1"></i></a>';
                             }
                             return $actions;
                         })
                         ->addColumn('photo', function ($row) {
                             if (!empty($row->adminUser->photo)) {
                                 return '<img src=' . asset($row->adminUser->photo) . ' width="50px" height="60px">';
                             }
                             return '<img src=' . asset(getAvatar()) . ' width="50%">';
                         })
                         ->editColumn('name', function ($row) {
                             return $row->first_name . ' ' . $row->last_name;
                         })
                         ->editColumn('user_group_id', function ($row) {
                             return isset($row->userGroup) ? $row->userGroup->group_name : '';
                         })
                         ->editColumn('status', function ($row) {
                             return setStatus($row->status);
                         })
                         ->rawColumns(['photo', 'status', 'action'])
                         ->filter(function ($query) use ($request) {
                             if ($request->get('name') != '') {
                                 $query->where('first_name', 'like', '%' . $request->get('name') . '%');
                                 $query->orWhere('last_name', 'like', '%' . $request->get('name') . '%');
                             }

                             if (!empty($request->get('email'))) {
                                 $query->where('email', $request->get('email'));
                             }

                             if (!empty($request->get('user_group_id'))) {
                                 $query->where('user_group_id', $request->get('user_group_id'));
                             }
                             $status = $request->get('status');
                             if (isset($status)) {
                                 $query->where('status', (int)$request->get('status'));
                             }
                         })
                         ->make(true);
    }

    /**
     * @param array $data
     *
     * @return insert_id
     */
    public function create($data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->model->create($data);
    }

    public function createUser($data)
    {
        DB::beginTransaction();
        // save user data to user table
        $userInfo = $this->model->create([
            'user_group_id'       => $data->user_group_id,
            'first_name'          => $data->first_name,
            'last_name'           => $data->last_name,
            'email'               => $data->email,
            'user_id'             => $data->user_id,
            'password'            => Hash::make($data->password),
            'email_notification'  => 1,
            'system_notification' => 1,
        ]);

        // save user data to admin user table
        $this->adminUserModel->create([
            'user_id'        => $userInfo->id,
            'department_id'  => $data->department_id,
            'designation_id' => $data->designation_id,
            'course_id'      => $data->course_id,
            'full_name'      => $userInfo->first_name . ' ' . $userInfo->last_name,
            'email'          => $userInfo->email,
            'address'        => $data->address,
            'phone'          => $data->phone_number,
            //'photo' => null,
            'photo'          => $data->photo,
            'status'         => 1,

        ]);

        DB::commit();
        return $userInfo;
    }

    public function updateUser($data, $id)
    {
        $userInfo = $this->find($id);
        DB::commit();
        // update user data to user table
        if (isset($data->password)) {
            $userInfo->update([
                'user_group_id'       => $data->user_group_id,
                'first_name'          => $data->first_name,
                'last_name'           => $data->last_name,
                'email'               => $data->email,
                'user_id'             => $data->user_id,
                'password'            => Hash::make($data->password),
                'status'              => $data->status,
                'email_notification'  => $userInfo->email_notification,
                'system_notification' => $userInfo->system_notification,
            ]);
        } else {
            $userInfo->update([
                'user_group_id'       => $data->user_group_id,
                'first_name'          => $data->first_name,
                'last_name'           => $data->last_name,
                'email'               => $data->email,
                'user_id'             => $data->user_id,
                'status'              => $data->status,
                'email_notification'  => $userInfo->email_notification,
                'system_notification' => $userInfo->system_notification,
            ]);
        }
        // update user data to admin user table
        $adminUserPhoto = $this->adminUserModel->where('user_id', $userInfo->id)->first();
        //keep previous photo if no new photo select during edit
        if (empty($data->photo)) {
            $data->photo = $adminUserPhoto->photo;
        }
        $userInfo->adminUser()->update([
            'user_id'        => $userInfo->id,
            'department_id'  => $data->department_id,
            'designation_id' => $data->designation_id,
            'course_id'      => $data->course_id,
            'full_name'      => $data->first_name . ' ' . $data->last_name,
            'email'          => $data->email,
            'address'        => $data->address,
            'phone'          => $data->phone_number,
            'photo'          => $data->photo,
            'status'         => $data->status,
        ]);

        DB::commit();
        return $userInfo;
    }

    /**
     * @param $userGroupId
     *
     * @return mixed
     */
    public function getUsersByGroupId($userGroupId)
    {
        return $this->model->where('user_group_id', $userGroupId)->get();
    }

    /**
     * get all the service providers with details
     * @return mixed
     */
    public function checkUserIdExist($request)
    {
        if ($request->has('id')) {
            return $this->model->where('id', '<>', $request->id)->where('user_id', $request->user_id)->count();
        }

        return $this->model->where('user_id', $request->user_id)->count();
    }

    public function checkUserEmailIsUnique($request)
    {
        if ($request->has('id')) {
            return $this->model->where('id', '<>', $request->id)->where('email', $request->email)->count();
        }

        return $this->model->where('email', $request->email)->count();
    }

    public function getUserByParentPhone($phone)
    {
        return $this->model->whereHas('parent', function ($q) use ($phone) {
            $q->where('father_phone', $phone);
        })->first();
    }

    public function getAllActiveUser()
    {
        return $this->model->where('status', 1)->get();
    }

    public function changePassword($password, $userId)
    {
        return $this->update([
            'password'        => Hash::make($password),
            'change_password' => 1
        ], $userId);
    }

    public function userChangePassword($request, $id)
    {
        $user = $this->find($id);
        if (Auth::guard('web')->user()->id != $id) {
            $this->update([
                'password'        => Hash::make($request->new_password),
                'change_password' => 0
            ], $id);

            $userMailBody = '
                    <table>
                        <tr>
                            <td>Dear ' . $user->adminUser->full_name . ',</td>
                        </tr>
                        <tr>
                            <td>Your Password has been reset </td>
                        </tr>
                        <tr>
                            <td>URL: ' . url('/') . ' </td>
                        </tr>
                        <tr>
                            <td>User ID: ' . $user->user_id . ' </td>
                        </tr>
                        <tr>
                            <td>Password: ' . $request->new_password . ' </td>
                        </tr>
                    <table>';
            $this->emailService->mailSend($user->adminUser->email, '', 'NEMC: User Password', 'password_reset', $userMailBody, '', $user);
            return $user;
        }
        $this->update([
            'password' => Hash::make($request->new_password),
        ], $id);
        return $user;
    }

    public function allUserListByStatus()
    {
        $users = $this->model
            ->with(['adminUser', 'teacher']) // Eager load relationships
            ->where(function ($query) {
                $query->whereHas('adminUser', function ($q) {
                    $q->where('status', 1); // Check status in adminUser table
                })
                      ->orWhereHas('teacher', function ($q) {
                          $q->where('status', 1); // Check status in teacher table
                      });
            })
            ->get(); // Fetch users as a collection

        $userList = [];

        foreach ($users as $user) {
            // Add related users
            if ($user->adminUser && $user->adminUser->status === 1) {
                $userList[$user->id] = $user->adminUser->full_name;
            } elseif ($user->teacher && $user->teacher->status === 1) {
                $userList[$user->id] = $user->teacher->first_name . ' ' . $user->teacher->last_name;
            }
        }

        return $userList;
    }
}
