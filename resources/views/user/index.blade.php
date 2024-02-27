@extends('layout.main')

@section('content')
    <div class="table-responsive mt-2">
        <table class="table table-dark table-striped">
            <h1 class="text-center">List of Users</h1>
            <tr>
                <th>Username</th>
                <th>Registration Timestamp</th>
                <th>Last Login Timestamp</th>
                <th>Profile</th>
                <th>Action</th>
            </tr>
            @foreach($users as $user)
                <tr>
                     <td>{{$user->username}}</td>
                     <td>{{$user->created_at}}</td>
                     <td>{{$user->last_login_at}}</td>
                     <td><a href="{{route('user.profile' , $user)}}" title="{{$user->username}} 's Profile Page">Link</a></td>
                     <td>
                        {{-- if user is not blocked --}}
                        @if($user->blocked_reason == null)
                            <form action="{{route('user.block' , $user)}}" method="post" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                @csrf
                                @method('PUT')
                                <select id="reason" name="reason" class="form-select">
                                    <option type="submit" value="spamming">
                                        Spamming
                                    </option>
                                    <option type="submit" value="cheating">
                                        Cheating
                                    </option>
                                    <option type="submit" value="other">
                                        Other
                                    </option>
                                </select>
                                <button type="submit" class="btn btn-primary">Block</button>
                            </form>
                            
                        @else
                            <form action="{{route('user.unblock' , $user)}}" method="post">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-secondary" id="btn-unblock" type="submit">Unblock</button>
                            </form>
                        @endif
                     </td>
                </tr>
            @endforeach
        </table>        
    </div>

@endsection