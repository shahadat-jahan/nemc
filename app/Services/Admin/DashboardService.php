<?php
/**
 * Created by PhpStorm.
 * User: sharif
 * Date: 11/22/18
 * Time: 11:05 AM
 */

namespace App\Services\Admin;


use App\Models\Customer;
use App\Models\Storage;
use App\Models\User;
use App\Services\BaseService;
use App\Services\UtilityServices;
use DB;
use App\Models\StorageSpaceLabel;
use function foo\func;
use Illuminate\Support\Facades\Auth;

class DashboardService extends BaseService
{
    //for models
    protected $user;

    /**
     * DashboardService constructor.
     * @param Customer $customerModel
     * @param User $userModel
     * @param Storage $storageModel
     */
    public function __construct(User $userModel)
    {
        $this->user = $userModel;
    }

    /**
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers() {
        return $this->user->all();
    }

    /**
     * status: 1 -- user
     * status: 2 -- service provider
     * @return mixed
     */
    public function getUserByStatus($status) {
        return $this->user->where('status', $status)->get();
    }

    /**
     * @param $groupId
     * @return mixed
     */
    public function getUserByGroupId($groupId=null) {
        return DB::table('users')->where('user_group_id', $groupId)->get();
    }





}
