@if(Session::has('userLogin'))
@include('navbar_user')
@else
@include('navbar_guest')
@endif

