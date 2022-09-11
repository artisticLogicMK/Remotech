<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\JobController;
use Illuminate\Auth\Events\Registered;
use Inertia\Inertia;

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
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
})->name('home');

Route::get('/board', [BoardController::class, 'index'])->name('dashboard');

Route::get('/board/company', [BoardController::class, 'showInfo'])->name('info')->middleware('auth');
Route::post('/board/company/update', [BoardController::class, 'updateInfo'])->name('updateInfo')->middleware('auth');
Route::post('/board/company/pass', [BoardController::class, 'passChange'])->name('passChange')->middleware('auth');


Route::get('/board/jobs', [JobController::class, 'index'])->name('listings')->middleware('auth');

Route::get('/board/jobs/create', [JobController::class, 'create'])->name('createJob')->middleware('auth');
Route::post('/board/jobs/create/store', [JobController::class, 'store'])->name('storeJob')->middleware('auth');

Route::get('/board/jobs/edit/{job}', [JobController::class, 'edit'])->name('editJob')->middleware('auth');
Route::post('/board/jobs/edit/{job}/update', [JobController::class, 'update'])->name('updateJob')->middleware('auth');

//delete job
Route::post('/board/jobs/delete/{job}', [JobController::class, 'destroy'])->name('deleteJob')->middleware('auth');

//deactivate/hide job
Route::post('/board/jobs/hide/{job}', [JobController::class, 'hide'])->name('hideJob')->middleware('auth');

//subscribe action
Route::post('/subscribe', [App\Http\Controllers\SubscribeController::class, 'store'])->name('subscribe');

require __DIR__.'/auth.php';


/*
Route::get('/sendmail', function() {
    if (event(new Registered(request()->user()))) {
        return redirect()->route('dashboard')->with('flash', ['msg' => 'Verification Link Sent!', 'type' => 'success']);
    } else {
        return redirect()->route('dashboard')->with('flash', ['msg' => 'Verification Not Sent!', 'type' => 'fail']);
    } 
})->name('sendMail');
*/