@extends('layout.main')

@section('content')
    <form action="{{route('login')}}" enctype="multipart/form-data" method="POST" class="my-3 w-50 mx-auto p-3">
        @csrf
        <div class="text-center">
            <h1>Admin Login</h1>
        </div>
        @include('layout.message')
        <div class="mb-2">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-2">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="d-flex justify-content-center">
            <button class="btn btn-dark">Login</button>
        </div>
    </form>
@endsection