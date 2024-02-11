<div class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a href="" class="navbar-brand">Admin Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth 
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{route('admin.index')}}" class="nav-link">List Admins</a>
                    </li>     
                    <li class="nav-item">
                        <a href="{{route('user.index')}}" class="nav-link">Manage Platform Users</a>
                    </li>  
                    <li class="nav-item">
                        <a href="{{route('game.index')}}" class="nav-link">Manage Games</a>
                    </li>  
                </ul>
                <div class="d-flex align-items-center gap-2 ms-auto">
                    <b class="text-white">{{Auth::user()->username}}</b>
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-success">Logout</button>
                    </form>
                </div>

                @else
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{route('loginPage')}}" class="nav-link">Login</a>
                        </li>   
                    </ul>         
                @endauth
        </div>
    </div>
</div>