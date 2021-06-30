<?php


namespace App\Repositories;


use App\Models\Cities;

class CityRepository
{
    public function getCityIdByName(string $name)
    {
        return Cities::where('name', $name)->first();
    }

    public function addCity(string $name)
    {
        return Cities::create([
            'name' => $name
        ]);
    }
}
