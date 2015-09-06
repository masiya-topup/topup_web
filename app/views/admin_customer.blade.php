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
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Topup</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
@stop

@section('jumbo_section')
@stop

@section('content')
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <hr/>
            <ul class="nav nav-pills nav-stacked">
                <li {{{ ($title == "tickets") ? "class=active" : '' }}}><a href="/admin/customer/tickets">Tickets</a></li>
            </ul>
            <hr/>
            <ul class="nav nav-pills nav-stacked">
                <li {{{ ($title == "users") ? "class=active" : '' }}}><a href="/admin/customer/users">Users</a></li>
            </ul>
            <hr/>
            <ul class="nav nav-pills nav-stacked">
                <li {{{ ($title == "logs") ? "class=active" : '' }}}><a href="/admin/customer/logs">Logs</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-md-10 main">
            @yield('admin_content')
        </div>
    </div>
@stop


@section('js_body_section')
@stop
