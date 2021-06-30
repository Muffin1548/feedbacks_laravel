<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserController;
use App\Models\Cities;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('dashboard', [FeedbackController::class, 'index'])->name('dashboard');

Route::get('/', [FeedbackController::class, 'index'])->name('dashboard');

Route::get('/new-feedback', function (){
    return view('feedbacks.create');
})->middleware(['auth'])->name('new-feedback');

Route::post('create', [FeedbackController::class, 'store'])->middleware(['auth']);


Route::get('edit/{slug}', [FeedbackController::class, 'edit']);

Route::get('user/{id}', [UserController::class, 'profile'])->where('id','[0-9]+')->name('profile');
