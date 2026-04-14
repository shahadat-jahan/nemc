<?php

namespace App\Services\Admin;

use App\Models\UserGroup;
use App\Models\UserGroupPermission;
use App\Services\BaseService;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class UserGroupService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    protected $userGroupPermission;

    /**
     * UserGroupService constructor.
     *
     * @param UserGroup $userGroup
     * @param UserGroupPermission $userGroupPermission
     */
    public function __construct(UserGroup $userGroup, UserGroupPermission $userGroupPermission)
    {
        $this->model = $userGroup;
        $this->userGroupPermission = $userGroupPermission;
    }

    /**
     * @return array
     */
    public function lists()
    {
        return $this->model->pluck('group_name', 'id');
    }

    public function listsByNotInGroupId(array $conditions)
    {
        return $this->model->whereNotIn('id', $conditions)->pluck('group_name', 'id');
    }

    /**
     * @param int $userGroupId
     * @return array
     */
    public function getPermissions($userGroupId)
    {
        $permissions = $this->model->find($userGroupId)->permissions;
        $permissionArray = [];

        foreach ($permissions as $key => $permission) {

            $permissionArray[$permission->action] = $permission->has_permission;
        }

        return $permissionArray;
    }

    /**
     * @param $userGroupId
     * @return array
     */
    public function getAvailablePermissions($userGroupId)
    {
        $results = $this->model->find($userGroupId)->permissions;

        $permissions = [];

        // for teacher and admin user
        if (Auth::guard('web')->check()){
            if (Auth::user()->teacher or Auth::user()->adminUser){
                $userId = Auth::id();
                $results = $results->whereIn('user_id', [null, $userId]);
            }
        }

        foreach ($results as $key => $permission) {
            $permissions[$permission->action] = $permission->has_permission;
        }

        return $permissions;
    }

    /**
     * Update user group permissions
     *
     * @param $request
     * @param $userGroupId
     * @return mixed
     */
    public function updatePermission($request, $userGroupId)
    {
        $this->userGroupPermission->where('user_group_id', $userGroupId)->delete();

        $permissions = [];

        foreach (Config::get('menu') as $key => $val) {

            if (sizeof($val['children']) > 0) {

                $data['user_group_id'] = $userGroupId;
                $data['action'] = $key;
                $data['has_permission'] = in_array($key, $request->input('action')) ? 1 : 0;
                $permissions[] = $data;

                foreach ($val['children'] as $cKey => $cVal) {

                    $data['user_group_id'] = $userGroupId;
                    $data['action'] = $cKey;
                    $data['has_permission'] = in_array($cKey, $request->input('action')) ? 1 : 0;
                    $permissions[] = $data;

                    foreach ($cVal['actions'] as $aKey => $aVal) {

                        $cData['user_group_id'] = $userGroupId;
                        $cData['action'] = $cKey.'/'.$aVal;
                        $cData['has_permission'] = in_array($cKey.'/'.$aVal, $request->input('action')) ? 1 : 0;

                        $permissions[] = $cData;
                    }
                }

            } else {

                $data['user_group_id'] = $userGroupId;
                $data['action'] = $key;
                $data['has_permission'] = in_array($key, $request->input('action')) ? 1 : 0;
                $permissions[] = $data;

                foreach ($val['actions'] as $aKey => $aVal) {

                    $data['user_group_id'] = $userGroupId;
                    $data['action'] = $key.'/'.$aVal;
                    $data['has_permission'] = in_array($key.'/'.$aVal, $request->input('action')) ? 1 : 0;
                    $permissions[] = $data;
                }

            }

        }
        return $this->userGroupPermission->insert($permissions);
    }

    public function getTeacherUserGroup(){
        return $this->model->whereNotIn('id', [1, 2, 3, 5, 6, 7])->get();
    }

    public function getAdminUserGroup(){
        $query = $this->model->doesntHave('users.student')
            ->doesntHave('users.teacher')
            ->doesntHave('users.parent')
            ->get();
        return $query;
    }

    public function getOnlyTeacherGroupPermissions($teacherGroupId){
        $permissions = $this->model->find($teacherGroupId)->permissions;
        $permissionArray = [];

        foreach ($permissions->where('user_id', null)->where('has_permission', 1) as $key => $permission) {

            $permissionArray[$permission->action] = $permission->has_permission;
        }

        return $permissionArray;
    }


    //get permission by groupId and userId for teacher extra permission
    public function getPermissionsByGroupIdAndUserId($userGroupId, $userId){
        $permissions = $this->model->find($userGroupId)->permissions;
        $permissionArray = [];

        foreach ($permissions->whereIn('user_id', [null, $userId]) as $key => $permission) {
            // teacher permission(with extra permission)
            if (Route::currentRouteName() == 'teacher.group.permission' or Route::currentRouteName() == 'admin.user.group.permission'){
                $permissionArray[$permission->action] = $permission->has_permission;
            }

        }

        return $permissionArray;
    }

    // set teacher extra permission
    public function updateTeacherModulePermission($request, $teacherUserId){
        // check current teacher has extra module permission
        $checkUseExtraPermissionExist = $this->userGroupPermission->where('user_id', $teacherUserId)
            ->where('user_group_id', $request->group_id)
            ->first();

        DB::beginTransaction();
        //if has extra permission then delete them
        if ($checkUseExtraPermissionExist){
            $this->userGroupPermission->where('user_id', $teacherUserId)->where('user_group_id', $request->group_id)->delete();
        }

        //get module action name which has permission
       $teacherGroupPermission = $this->userGroupPermission->where('user_group_id', $request->group_id)
           ->where('has_permission', 1)
           ->pluck('action');
       // identify new permissions(extra permission than user group) and save to table
        foreach ($request->action as $requestAction){
            if (!$teacherGroupPermission->contains($requestAction)){
                DB::table('user_group_permissions')->insert([
                    'user_group_id' => $request->group_id,
                    'action' => $requestAction,
                    'user_id' => $teacherUserId,
                    'has_permission' => 1,
                ]);
            }
        }

        DB::commit();

        return $teacherGroupPermission;
    }

    public function updateAdminUserModulePermission($request, $userId){
        // check current user has extra module permission
        $checkUseExtraPermissionExist = $this->userGroupPermission->where('user_id', $userId)
            ->where('user_group_id', $request->group_id)
            ->first();

        DB::beginTransaction();
        //if has extra permission then delete them
        if ($checkUseExtraPermissionExist){
            $this->userGroupPermission->where('user_id', $userId)->where('user_group_id', $request->group_id)->delete();
        }

        //get module action name which has permission
        $UserCurrentGroupPermission = $this->userGroupPermission->where('user_group_id', $request->group_id)
            ->where('has_permission', 1)
            ->pluck('action');

        // identify new permissions(extra permission than user group) and save to table
        foreach ($request->action as $requestAction){
            if (!$UserCurrentGroupPermission->contains($requestAction)){
                DB::table('user_group_permissions')->insert([
                    'user_group_id' => $request->group_id,
                    'action' => $requestAction,
                    'user_id' => $userId,
                    'has_permission' => 1,
                ]);
            }
        }

        DB::commit();

        return $UserCurrentGroupPermission;
    }

}
