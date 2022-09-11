<?php

namespace App\Http\Controllers;
use App\Models\Job;
use ArrayObject;
use Carbon\Carbon;
use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BoardController extends Controller
{
    public function index(){

      $joinQuery = request('kw').' '.request('sk');

      $jobs = Job::search($joinQuery)->bookmark(request('bk'))->where('hidden', '=', null)->where('close_time', '>', time())->orderBy('id', 'DESC')->paginate(10)->through(function($job) {
        return [
          'id' => $job->id,
          'companyLogo' => $job->user->logo,
          'companyName' => $job->companyName,
          'title' => $job->title,
          'about' => $job->about,
          'skills' => explode(' ', $job->skills),
          'type' => $job->type,
          'salary' => $job->salary,
          'salary_interval' => $job->salary_interval,
          'close_date' => $job->close_date,
        ];
      });

      $jobview = null;

      //fetch job if job view request is set
      if (request('jb') ?? false) {

        $jobview = Job::find(request('jb'));

        if ($jobview ?? false) {

          $jobview->push([ 'user' => $jobview->user ]);

        } else {

          return redirect()->route('dashboard')->with('flash', ['msg' => 'Not Found...', 'type' => 'fail']);

        }

      } else  {

        if (count($jobs) > 0) {

          $jobview = Job::find($jobs->first()['id']);
          $jobview->push([ 'user' => $jobview->user ]);

        } else {

          $jobview = null;

        }

      }

      $params = [
        'keyword' => request('kw') ?? '',
        'skills' => request('sk') ? explode(' ', request('sk')) : []
      ];

      return Inertia::render('Dashboard', compact('jobs', 'jobview'))->with('searchParams', $params);
    }

    //show company info edit
    public function showInfo() {
      return Inertia::render('CompanyInfo');
    }

    public function updateInfo(Request $req) {

      $info = $req->validate([
        'name' => ['required','string', 'max:20', 'min:2', Rule::unique('users', 'name')->ignore(($req->user()->id))],
        //'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(($req->user()->id))],
        'website' => 'required|string|url',
        'logo' => 'image|max:5048|mimetypes:image/png,image/jpeg,image/webp|nullable'
      ]);
      
      if ($req->hasFile('logo')) {

        $pathname = 'remote/'.'_'.time().$req->file('logo')->hashName(); //create pathname name

        //crop and compress image with intervention
        $image = Image::make($req->file('logo'))->fit(300, 300)->encode('jpg', 75);
        //$image->save(public_path('storage/images/').'000.jpg');

        Storage::disk('s3')->put($pathname, $image->__toString()); //upload to s3 bucket
        $info['logo'] = 'https://artistic1.s3.amazonaws.com/'.$pathname; //store path

      }

      if ($req->user()->update($info)) {

        //update company jobs
        $req->user()->jobs()->update(['companyName' => $req->name]);

      }

      return redirect()->route('info')->with('flash', ['msg' => 'Info Successfully Updated!', 'type' => 'success']);
    }


    public function passChange(Request $req) {
      
      $pass = $req->validate([
        'current_password' => 'required',
        'password' => 'required|confirmed|min:8',
        'password_confirmation' => 'required'
      ]);

      if (Auth::attempt(['name' => $req->user()->name, 'password' => $req->current_password])) {

        $req->user()->update(['password' => Hash::make($req->password)]);
        return redirect()->route('info')->with('flash', ['msg' => 'Password changed successfully.', 'type' => 'success'])->with('passChange', true);

      } else {

        return redirect()->route('info')->with('flash', ['msg' => 'Wrong password.', 'type' => 'fail'])->with('passChange', true);

      }
    }
}
