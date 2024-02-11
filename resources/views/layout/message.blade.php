@if(Session::has('error'))
    <div class="text-center">
        <div class="alert alert-danger">{{Session::get('error')}}</div>
    </div>
@elseif(Session::has('success'))
    <div class="text-center">
        <div class="alert alert-success">{{Session::get('success')}}</div>
    </div>
@endif