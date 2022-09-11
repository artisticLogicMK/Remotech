<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    //show job listings
    public function index(Request $req){
      if (Auth::check()) {

        $companyJobs = Job::where('user_id', '=', $req->user()->id)->paginate(25)->through(function($job) {
          return [
            'id' => $job->id,
            'title' => $job->title,
            'close_date' => $job->close_date,
            'close_time' => $job->close_time,
            'hidden' => $job->hidden,
          ];
        });

        return Inertia::render('Listings', compact('companyJobs'));

      } 
    }

    //show job create form
    public function create(){
      if (request()->user()->can('create', Job::class)) {

        return Inertia::render('Postjob');

      } else {

        return redirect()->route('info')->with('flash', ['msg' => 'Email and website must be filled to post jobs.', 'type' => 'fail']);
      
      }
    }

    //store job
    public function store(JobRequest $req){
      if (request()->user()->can('create', Job::class)) {

        Job::create($req->validated());

        return redirect()->route('listings')->with('flash', ['msg' => 'Job Created Successfully!', 'type' => 'success']);

      } else {

        return redirect()->route('listings');

      }
    }

    //show edit form
    public function edit(Job $job){
      if (request()->user()->cannot('update',$job)) {

        $job = null;

      }
      
      return Inertia::render('Editjob', compact('job'));

    }

    //update job
    public function update(Job $job, JobRequest $req){
      if (request()->user()->can('update',$job)) {

        $job->update($req->validated());

        return redirect()->route('editJob', $job->id)->with('flash', ['msg' => 'Job Updated Successfully!','type' => 'success']);

      } else {
        
        return redirect()->route('editJob', $job->id);

      }
    }

    //hide/show job
    public function hide(Job $job) {
      if (request()->user()->can('update',$job)) {

        $val = $job->hidden == 1 ? null : 1;

        $job->update(['hidden' => $val]);

        return redirect()->route('listings')->with('flash', [
          'msg' => $val == 1 ? 'Job hidden from public view.' : 'Job visible to public view.',
          'type' => 'success'
        ]);

      }
    }

    //delete job
    public function destroy(Job $job, Request $req) {
      
      $del = $req->validate([
        'password' => 'required',
      ]);

      if (Auth::attempt(['name' => $req->name, 'password' => $req->password]) && $req->user()->can('update',$job)) {

        $job->delete();
        return redirect()->route('listings')->with('flash', ['msg' => 'Job Deleted!', 'type' => 'success']);

      } else {

        return redirect()->route('editJob', $job->id)->with('delJob', 'Wrong Password!');

      }
    }
}
