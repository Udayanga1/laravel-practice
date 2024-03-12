@extends('layouts.app')

@section('content')
    <div class="container">
      <div class="row">
          <div class="col-lg-12 text-center">
              <h1 class="page-title">My Todo List</h1>
          </div>
          <div class="col-lg-12">
            <form action="{{ route('todo.store') }}" method="post">
              @csrf
              <div class="row g-3">
                <div class="col-8">
                  <input type="text" name="title" class="form-control" placeholder="Enter Task">
                </div>
                <div class="col-4">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-lg-12">
            <div>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($tasks as $key => $task)
                  <tr>
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ $task -> title }}</td>
                    @if ($task -> done === 0)
                        <td class="table-warning">Not Completed</td>
                    @else
                        <td class="table-success">Completed</td>
                    @endif
                    <td>
                      <a href="{{ route('todo.delete', $task->id) }}" class="btn btn-danger">Delete</a>
                      <a href="{{ route('todo.done', $task->id) }}" class="{{ ($task -> done) ? 'btn btn-success' : 'btn btn-secondary' }}">Done</a>
                    </td>
                  </tr>                      
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
@endsection

@push('css')
  <style>
      .page-title {
          margin-top: 20px;
          margin-bottom: 20px;
          font-size: 5rem;
          color: rgb(70, 184, 142)
      }
  </style>
@endpush
