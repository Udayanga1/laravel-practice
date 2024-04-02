<?php

namespace App\Models;

class Job {
    public static function all(): array
    {
        return [
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

    }

    public static function find(int $id): array
    {
      $job = \Illuminate\Support\Arr::first(static::all(), fn($job) => $job['id'] == $id);

      if (!$job) {
          abort(404);
      } else {
          return $job;
      }
    }
}