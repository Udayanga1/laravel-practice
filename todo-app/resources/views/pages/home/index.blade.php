@extends('layouts.app')

@section('content')
    <div class="container">
      <div class="row">
          <div class="col-lg-12 text-center">
              <h1 class="page-title">Home Page</h1>
          </div>
      </div>
    </div>
@endsection

@push('css')
  <style>
      .page-title {
          margin-top: 20px;
          font-size: 5rem;
          color: rgb(51, 121, 190)
      }
  </style>
@endpush