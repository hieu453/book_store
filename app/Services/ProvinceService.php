<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ProvinceService
{
    public function __construct() {}

    public function getProvinces()
    {
        $provinces = Cache::get('provinces', function () {
            return Http::get('https://provinces.open-api.vn/api/?depth=3')->json();
        });

        $provincesCollection = collect($provinces);

        $cities = $provincesCollection->map(function ($province) {
            return $province['name'];
        });

        $districts = $provincesCollection->map(function ($province) {
            return collect($province['districts'])->map(function ($district) {
                return $district['name'];
            });
        })->flatten()->all();

        $wards = $provincesCollection->map(function ($province) {
            return collect($province['districts'])->map(function ($district) {
                return collect($district['wards'])->map(function ($ward) {
                    return $ward['name'];
                });
            });
        })->flatten()->all();

        return [
            'cities' => $cities,
            'districts' => $districts,
            'wards' => $wards,
        ];
    }
}
