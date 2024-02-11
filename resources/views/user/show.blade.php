@extends('layout.main')

@section('content')
    <div class="card w-50 mt-3 mx-auto">
        <div class="card-body">
            <h1>{{$user->username}}</h1>
        </div>
    </div>

@endsection