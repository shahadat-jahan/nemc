<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationSettingRequest;
use App\Models\ApplicationSetting;
use App\Services\Admin\ApplicationSettingService;
use Illuminate\Http\Request;

class ApplicationSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $applicationSettingService;

    protected $redirectUrl;

    public function __construct(ApplicationSettingService $applicationSettingService, ApplicationSetting $applicationSetting){
        $this->redirectUrl = 'admin/application_setting';
        $this->applicationSettingService = $applicationSettingService;
        $this->applicationModel = $applicationSetting;
    }


    public function index() {
        $data['pageTitle'] = 'Application-Setting';
        $data['applicationInfo'] = $this->applicationModel->first();

        return view('applicationSetting.index', $data);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationSettingRequest $request, $id) {

        $applicationInfo = $this->applicationSettingService->update($request->all(), $id);

        if ($applicationInfo) {
            \Setting::updateSiteSetting();
            $request->session()->flash('success', setMessage('update', 'Application Setting'));
            return redirect()->route('application.setting.index');
        }

        $request->session()->flash('error', setMessage('update.error', 'Application Setting'));
        return redirect()->route('application.setting.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
