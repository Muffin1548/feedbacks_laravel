<?php


namespace App\Services;


use App\Repositories\FeedbacksRepository;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FeedbacksService
{
    private FeedbacksRepository $feedbacksRepository;
    private CityServices $cityService;

    public function __construct()
    {
        $this->feedbacksRepository = new FeedbacksRepository();
        $this->cityService = new CityServices();
    }

    public function getFeedbacks(string $city)
    {
        return $this->feedbacksRepository->getFeedbacksByCityName($city);
    }

    public function store(array $data)
    {
        if(isset($data['city_id'])) {
            $cityName = $this->cityService->getCityByName($data['city_id']);
            $data['city_id'] = $cityName->id;
        }
        $this->feedbacksRepository->createFeedback($data);
    }

}
