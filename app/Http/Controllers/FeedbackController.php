<?php


namespace App\Http\Controllers;


use App\Http\Requests\FeedbacksFormRequest;
use App\Models\Cities;
use App\Models\Feedbacks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class FeedbackController extends Controller
{

    public function index(Request $request)
    {
        $ip = $request->getClientIp();
        $city = $request->city;
        $city_id = Cities::where('name', $city)->first();
        $title = 'Latest feedbacks';

        $feedbacks = Feedbacks::all();
        if ($request->ajax()) {
            $request->session()->put('name', $city);
            $feedbacks = Feedbacks::where('city_id', $city_id->id)->get();
            return view('ajax', compact('feedbacks', 'title'))->render();
        }


        if($request->session()->has('name'))
        {
            $city_id = Cities::where('name', $request->session()->get('name'))->first();
            $feedbacks = Feedbacks::where('city_id', $city_id->id)->get();

            return view('dashboard', compact('feedbacks', 'title'))->render();
        }

        return view('dashboard',compact('feedbacks'));
    }

    public function store(Request $request)
    {

        Feedbacks::create([
            'city_id' => $request->city,
            'title' => $request->get('title'),
            'text' => $request->get('text'),
            'rating' => $request->rating,
            'author_id' => $request->user()->id,
        ]);
        return redirect('dashboard');
    }

    public function create()
    {
        return view('feedbacks.create');
    }

    public function getWithFilter(Request $request)
    {
        $city_id = $request->item;

        $filter = Feedbacks::where('city_id', $city_id);
        if (isset($request->item)) {

            $filter = Cities::where('city_id', $request->item)->get();
        }

        if ($request->ajax()) {
            return view('ajax', compact('filter'))->render();
        }
    }

}
