@extends('layout.main')

@section('content')
    <div class="card w-75 mt-3 mx-auto">
        <div class="card-head p-2">
            <h1>{{$game->title}}</h1>
            <h3>Created by: {{$game->author->username}}</h3>
        </div>
        <div class="card-body">
            <h2 class="text-center">Scores</h2>
            {{-- Reset highscore --}}
                <form action="{{route('score.destroyAll' , $game)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-primary ms-auto d-block" id="btn-delete" type="submit">Reset Score</button>
                </form>            
            @foreach($game->gameVersions as $version)
            <div><b>{{$version->version}}</b></div>
            <table class="table table-dark table-striped">
                <tr>
                    <th>Player</th>
                    <th>Score</th>
                    <th>Action 1</th>
                    <th>Action 2</th>
                </tr>

                @foreach($version->gameScores->sortByDesc('score') as $score)
                    <tr>
                        <td>{{$score->user->username}}</td>
                        <td>{{$score->score}}</td>
                        <td>
                            <form action="{{route('score.destroy' , $score)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-secondary" id="btn-delete" type="submit">Delete This Score</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{route('score.destroyPlayer' ,[$score->user , $game] )}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-secondary" id="btn-delete" type="submit">Delete All This Player's Score</button>
                            </form>
                        </td>
                    </tr>

                @endforeach
            </table>     

            @endforeach
        </div>
    </div>

@endsection