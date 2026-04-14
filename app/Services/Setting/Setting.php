<?php

namespace App\Services\Setting;


use App\Services\Admin\ApplicationSettingService;
use Illuminate\Support\Facades\Cache;

/**
 * Class SiteSetting
 * @package App\Services\Setting
 */
class Setting
{
    /**
     * @var Setting
     */
    protected $setting;

    /**
     * SiteSetting constructor.
     * @param Setting $setting
     */
    public function __construct(ApplicationSettingService $setting)
    {
        $this->setting = $setting;
        $this->setSiteSetting();
    }

    /**
     *
     */
    public function setSiteSetting()
    {
        if (!Cache::has('nemc-setting')) {
            $siteSetting = $this->setting->find(1);
            Cache::forever('nemc-setting', $siteSetting);
        }
    }

    /**
     *
     */
    public function updateSiteSetting()
    {
        $this->deleteSiteSetting();
        $siteSetting = $this->setting->find(1);
        Cache::forever('nemc-setting', $siteSetting);
    }

    /**
     * @return mixed
     */
    public function getSiteSetting()
    {
        return Cache::get('nemc-setting');
    }

    /**
     *
     */
    public function deleteSiteSetting(){
        Cache::forget('nemc-setting');
    }

}