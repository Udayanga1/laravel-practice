<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/jobs', function () {
    return view('jobs', [
        'jobs' => [
            [
                'id' => 1,
                'title' => 'Laravel Developer',
                'salary' => '$10,000 per month',
            ],
            [
                'id' => 2,
                'title' => 'React Developer',
                'salary' => '$12,000 per month',
            ],
            [
                'id' => 3,
                'title' => 'Angular Developer',
                'salary' => '$11,000 per month',
            ],
        ]
    ]);
});

Route::get('/jobs/{id}', function ($id) {
    $jobs = [
            [
                'id' => 1,
                'title' => 'Laravel Developer',
                'salary' => '$10,000 per month',
            ],
            [
                'id' => 2,
                'title' => 'React Developer',
                'salary' => '$12,000 per month',
            ],
            [
                'id' => 3,
                'title' => 'Angular Developer',
                'salary' => '$11,000 per month',
            ],
    ];

    $job = \Illuminate\Support\Arr::first($jobs, fn($job) => $job['id'] == $id);

    return view('job', [
        'job' => $job
    ]);
});

Route::get('/contact', function () {
    return view('contact');
});
