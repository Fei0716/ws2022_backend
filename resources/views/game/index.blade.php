@extends('layout.main')

@section('content')
    <h1 class="text-center my-2">List of Games</h1>
    <input type="search" placeholder="Search for games..." name="filter_list" id="filter_list" class="form-control w-50 mx-auto">

    <div class="table-responsive mt-2">
        <table class="table table-dark table-striped">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Author</th>
                <th>Version Timestamp</th>
                <th></th>
            </tr>
            @foreach($games as $game)
                <tr class="game">
                     <td class="text-center">
                        <div><b><a href="{{route('game.show' , $game)}}" title="Game Page" class="game-title">{{$game->title}}</b></div>
                        @if($game->thumbnail != null)</a>
                            <img src="{{URL($game->thumbnail)}}" alt="Game Thumbnail" height="250" width="300" class="d-block mx-auto">
                        @endif
                    </td>
                     <td class="game-description">{{$game->description}}</td>
                     <td class="game-author">{{$game->author->username}}</td>
                     <td>
                        <ol>
                            @foreach ($game->gameVersions as $gameVersion)
                             <li>{{$gameVersion->version}}({{$gameVersion->created_at}})</li>
                            @endforeach
                        </ol>
                     </td>
                     <td>
                        @if($game->deleted_at == null)
                            <form action="{{route('game.destroy' , $game)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-secondary" id="btn-delete" type="submit">Delete</button>
                            </form>
                        @else
                            Deleted
                        @endif
                     </td>
                </tr>
            @endforeach
        </table>        
    </div>

@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        // for filter functionality
        document.getElementById('filter_list').addEventListener('input',function(){
            var input = this.value;
            const currentList = [...document.getElementsByClassName('game')];//convert to array
            currentList.forEach((item)=>{
                let title = item.getElementsByClassName('game-title')[0].innerHTML.toUpperCase();
                let description = item.getElementsByClassName('game-description')[0].innerHTML.toUpperCase();
                let author = item.getElementsByClassName('game-author')[0].innerHTML.toUpperCase();

                if(title.includes(input.toUpperCase()) ||description.includes(input.toUpperCase())|| author.includes(input.toUpperCase())){ 
                    item.style.display = "";
                }else{
                    item.style.display = "none";
                }
            });
        });
    });    
</script>

@endsection