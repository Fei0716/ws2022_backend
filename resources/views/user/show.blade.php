@extends('layout.main')

@section('content')
    <div class="card w-50 mt-3 mx-auto">
        <div class="card-head p-2">
            <h1>{{$user->username}}</h1>
            <div>Registered at: {{$user->created_at}}</div>
        </div>
        <div class="card-body">
            <div>
                <h3>Scores</h3>
                <ul class="list-group">
                    @foreach($user->gameScores as $score)
                        <li class="list-group-item">{{$score->score}}({{$score->gameVersion->game->title}})</li>
                    @endforeach
                </ul>
            </div>

            @if(count($user->games) > 0)
                <div>
                    <h3>Developed Games</h3>
                    <ul class="list-group">
                        @foreach($user->games as $game)
                            <li class="list-group-item">{{$game->title}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

@endsection