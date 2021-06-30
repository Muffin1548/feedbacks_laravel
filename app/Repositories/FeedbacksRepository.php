<?php


namespace App\Repositories;


use App\Models\Feedbacks;

class FeedbacksRepository
{
    private $cityRepository;

    public function __construct()
    {
        $this->cityRepository = new CityRepository();
    }

    public function getFeedbacksByCityId(int $id)
    {
        return Feedbacks::where('city_id', $id)->orWhere('city_id')->get();
    }

    public function getFeedbacksByCityName(string $name)
    {
        $cityId = $this->cityRepository->getCityIdByName($name);

        return $this->getFeedbacksByCityId($cityId->id);
    }

    public function createFeedback(array $data)
    {
        return Feedbacks::create($data);
    }

    public function getFeedbackByTitle(string $title)
    {
        return Feedbacks::where('title', $title)->first();
    }
}
