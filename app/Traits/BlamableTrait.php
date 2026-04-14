<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait BlamableTrait
{
    public static function bootBlamableTrait()
    {

        static::creating(function (Model $model){

            if(Auth::guard('web')->check()){
                $user = Auth::guard('web')->user()->id;
            }else if(Auth::guard('student_parent')->check()){
                $user = Auth::guard('student_parent')->user()->id;
            }else{
                $user = 1;
            }

            $model->created_by = $user;
            $model->updated_by = $user;
        });

        static::updating(function (Model $model) {

            if(Auth::guard('web')->check()){
                $user = Auth::guard('web')->user()->id;
            }else if(Auth::guard('student_parent')->check()){
                $user = Auth::guard('student_parent')->user()->id;
            }else{
                $user = 1;
            }

            $model->updated_by = $user;

        });

        static::deleting(function (Model $model) {

            if(Auth::guard('web')->check()){
                $user = Auth::guard('web')->user()->id;
            }else if(Auth::guard('student_parent')->check()){
                $user = Auth::guard('student_parent')->user()->id;
            }else{
                $user = 1;
            }

            $model->updated_by = $user;

        });
    }
}
