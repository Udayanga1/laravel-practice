@extends('layouts.app')

@section('content')
    <div class="container">
      <div class="row">
          <div class="col-lg-12 text-center">
              <h1 class="page-title">My Banner List</h1>
          </div>
          <div class="col-lg-12">
            <form action="{{ route('banner.store') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="row g-3">
                <div class="col-8">
                  <div class="form-group">
                    <input type="text" name="title" class="form-control" placeholder="Enter Banner Title">
                  </div>
                  <div class="form-group mt-3">
                    <input type="file" name="images" class="form-control" placeholder="Enter Banner Image" accept="image/jpg, image/jpeg, image/png,">
                  </div>
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
                  @foreach ($banners as $key => $banner)
                  <tr>
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ $banner -> title }}</td>
                    @if ($banner -> status === 0)
                        <td class="table-warning">Not Completed</td>
                    @else
                        <td class="table-success">Completed</td>
                    @endif
                    <td>
                      <a href="{{ route('banner.delete', $banner->id) }}" class="btn btn-danger">Delete</a>
                      <a href="{{ route('banner.status', $banner->id) }}" class="{{ ($banner -> status) ? 'btn btn-success' : 'btn btn-secondary' }}">Status</a>
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
