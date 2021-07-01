<?php


namespace App\Services;

use App\Repositories\FeedbacksRepository;

class FeedbacksService
{
    private FeedbacksRepository $feedbacksRepository;
    private CityServices $cityService;

    public function __construct()
    {
        $this->feedbacksRepository = new FeedbacksRepository();
        $this->cityService = new CityServices();
    }


    public function getAllFeedbacks()
    {
        return $this->feedbacksRepository->getAllFeedbacks();
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

    public function getFeedbackById(int $id)
    {
        return $this->feedbacksRepository->getFeedbackById($id);
    }

    public function update(int $id, array $data)
    {
        $feedback = $this->getFeedbackById($id);
        if ($feedback) {
            $feedback['title'] = $data['title'];;
            $feedback['text'] = $data['text'];
            $feedback['city_id'] = $data['city_id'];
            $feedback['author_id'] = $data['author_id'];
            $feedback['rating'] = $data['rating'];
            return $this->feedbacksRepository->updateFeedback($feedback);
        } else {
            return false;
        }
    }


}
