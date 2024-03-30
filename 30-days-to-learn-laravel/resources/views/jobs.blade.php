<x-layout>
    <x-slot:heading>
        Jobs
    </x-slot:heading>
    <h1>Hello from Jobs</h1>
    <h2>{{ $jobs[2]['salary'] }}</h2>
    <ul>
        @foreach ($jobs as $job)
            <a href="/jobs/{{ $job['id'] }}">
                <li>{{ $job['title'] }}: Salary - {{ $job['salary'] }}</li>
            </a>
        @endforeach
    </ul>
</x-layout>