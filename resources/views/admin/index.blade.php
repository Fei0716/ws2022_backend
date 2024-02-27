@extends('layout.main')

@section('content')
    <div class="table-responsive mt-2">
        <h1 class="text-center">List of Admins</h1>
        <table class="table table-dark table-striped">
            <tr>
                <th>Username</th>
                <th>Created Timestamp</th>
                <th>Last Login</th>
            </tr>
            @foreach($adminUsers as $adminUser)
                <tr>
                     <td>{{$adminUser->username}}</td>
                     <td>{{$adminUser->created_at}}</td>
                     <td>{{$adminUser->last_login_at}}</td>
                </tr>
            @endforeach
        </table>        
    </div>

@endsection