@extends('layout.master')

@section('css_head_section')
{{ HTML::style('css/_lib/bootgrid/jquery.bootgrid.css') }}  
@stop

@section('js_head_section')
{{ HTML::script('js/_lib/bootgrid/jquery.bootgrid.js') }}
{{ HTML::script('js/_lib/bootgrid/jquery.bootgrid.fa.js') }}
{{ HTML::script('js/_lib/validate/jquery.validate.js') }}
@stop

@section('nav_section')
@include('navbar', ['page' => 'user'])
@stop

@section('jumbo_section')
<div class="jumbotron">
    <div class="container">&nbsp;</div>
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <hr/>
            <ul class="nav nav-pills nav-stacked">
                <li {{{ ($title == "topup") ? "class=active" : '' }}}><a href="/user/profile/topup">Topup</a></li>
            </ul>
            <hr/>
            <ul class="nav nav-pills nav-stacked">
                <li {{{ ($title == "logs") ? "class=active" : '' }}}><a href="/user/profile/logs">Logs</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-md-10 main">
            @yield('user_content')
        </div>
    </div>
@stop