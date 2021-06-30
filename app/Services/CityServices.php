<?php


namespace App\Services;


use App\Repositories\CityRepository;

class CityServices
{
    private $cityRepository;

    public function __construct()
    {
        $this->cityRepository = new CityRepository();
    }

    public function getCityByName(string $name)
    {
        $city = $this->cityRepository->getCityIdByName($name);

        if (isset($city)){
            return $city;
        }else {
            $this->cityRepository->addCity($name);
            return $this->cityRepository->getCityIdByName($name);
        }
    }
}
