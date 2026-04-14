<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;

class StudentParentController extends Controller
{
    public function index() {
        return redirect('/home');
    }
    public function home() {
        $data['pageTitle'] = 'Student-Parent|Home';
        return view('frontend.auth.home', $data);
    }


}
