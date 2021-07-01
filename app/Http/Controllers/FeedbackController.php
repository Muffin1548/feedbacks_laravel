<?php


namespace App\Http\Controllers;

use App\Services\FeedbacksService;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class FeedbackController extends Controller
{
    private FeedbacksService $feedbacksService;
    private ImageService $imgService;

    public function __construct()
    {
        $this->feedbacksService = new FeedbacksService();
        $this->imgService = new ImageService();
    }

    public function index(Request $request)
    {

        $feedbacks = $this->feedbacksService->getAllFeedbacks();

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

        $validator = Validator::make($data, [
            'title' => 'required|max:100',
            'text' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('new-feedback')->withErrors('Title already exist or something else')->withInput();
        } else {
            $this->feedbacksService->store($data);
            return redirect('dashboard')->with('message', 'Feedback published successfully');
        }

    }

    public function create()
    {
        return view('feedbacks.create');
    }


    public function edit($slug)
    {
        $data = explode('-', $slug);
        $feedback = $this->feedbacksService->getFeedbackById($data[0]);
        return view('feedbacks.edit', compact('feedback'));
    }

    public function update(Request $request)
    {

        $data = [
            'city_id' => $request->city,
            'title' => $request->get('title'),
            'text' => $request->get('text'),
            'rating' => $request->rating,
            'author_id' => $request->user()->id,
        ];

        $feedbackId = $request->input('feedback_id');
        $slug = Str::slug($feedbackId.'-'.$data['title']);

        $validator = Validator::make($data, [
            'title' => 'required|max:100',
            'text' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('edit/' . $slug)->withErrors('Title already exist or something else')->withInput();
        } else {
            $this->feedbacksService->update($feedbackId, $data);
            return redirect('dashboard')->with('message', 'Feedback updated successfully');
        }
    }

}
