<?php
/**
 * Created by PhpStorm.
 * User: office
 * Date: 2/6/19
 * Time: 5:41 PM
 */

namespace App\Services;


use App\Models\Country;

class CountryService extends BaseService
{

    public function __construct(Country $country)
    {
        $this->model = $country;
    }

    public function lists()
    {
        return $this->model->where('status', 1)->orderBy('name', 'asc')->pluck('name', 'id');
    }
}