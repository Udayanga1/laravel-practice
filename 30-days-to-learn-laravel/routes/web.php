<?php

use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');

});

Route::get('/jobs', function () {
    return view('jobs', [   // 'jobs' is the name of the view file (jobs.blade.php)
        'jobs' => Job::all() // 'jobs' is the variable name that will be available in the view (route parameter)
    ]);
});

Route::get('/jobs/{id}', function ($id) {
        $job = Job::find($id);

        return view('job', [
            'job' => $job
        ]);
});

Route::get('/contact', function () {
    return view('contact');
});
