<?php


namespace App\Http\Controllers;


use App\Models\Cities;
use App\Models\Feedbacks;
use App\Services\CityServices;
use App\Services\FeedbacksService;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class FeedbackController extends Controller
{
    private FeedbacksService $feedbacksService;
    private ImageService $imgService;
    private CityServices $cityService;

    public function __construct()
    {
        $this->feedbacksService = new FeedbacksService();
        $this->imgService = new ImageService();
        $this->cityService = new CityServices();
    }

    public function index(Request $request)
    {

        $feedbacks = Feedbacks::all();

        if ($request->ajax()) {
            $city = $request->city;
            $request->session()->put('city', $city);
            $feedbacks = $this->feedbacksService->getFeedbacks($city);
            return view('ajax', compact('feedbacks'));
        }

        if($request->session()->has('city'))
        {
            $cityName = $request->session()->get('city');
            $feedbacks = $this->feedbacksService->getFeedbacks($cityName);
        }
        //$request->session()->forget('city');
        return view('dashboard',compact('feedbacks'));
    }

    public function store(Request $request)
    {
        $filename = null;

        if($request->hasFile('image')) {
            $img = $request['image'];
            $filename = $this->imgService->addImg($img);
        }

        $data = [
            'city_id' => $request->city,
            'title' => $request->get('title'),
            'text' => $request->get('text'),
            'rating' => $request->rating,
            'author_id' => $request->user()->id,
            'img' => $filename
        ];

        $this->feedbacksService->store($data);

        return redirect('dashboard');
    }

    public function create()
    {
        return view('feedbacks.create');
    }


    public function edit($slug)
    {
        $feedback = Feedbacks::where('title', $slug)->first();
        return view('feedbacks.edit', compact('feedback'));
    }

}
