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

    public function getAllFeedbacks()
    {
        return Feedbacks::all();
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

    public function getFeedbackById(int $id)
    {
        return Feedbacks::where('id', $id)->first();
    }

    public function updateFeedback(Feedbacks $feedbacks): bool
    {
        return $feedbacks->save();
    }
}
