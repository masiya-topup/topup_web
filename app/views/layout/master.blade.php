<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Topup :: {{$title}}</title>
    <link rel="canonical" href="{{URL::current()}}" />
<!--    <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">-->
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"></script>-->
    
    <link media="all" type="text/css" rel="stylesheet" href="{{url('/css/_lib/bootstrap/bootstrap.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{url('/css/_lib/bootstrap/bootstrap-theme.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{url('/css/_lib/jqueryui/jquery-ui.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{url('/css/_lib/jqueryui/jquery-ui.structure.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{url('/css/_lib/jqueryui/jquery-ui.theme.css')}}">
    <script src="{{url('/js/_lib/jquery/jquery.js')}}"></script>
    <script src="{{url('/js/_lib/jqueryui/jquery-ui.js')}}"></script>
    <script src="{{url('/js/_lib/bootstrap/bootstrap.js')}}"></script>
@yield('css_head_section')
@yield('js_head_section')
    <style>
    html {
        position: relative;
        min-height: 100%;
    }
    body {
        min-height: 1000px;
        padding-top: 70px;
        margin-bottom: 60px;
    }
    #footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        /* Set the fixed height of the footer here */
        height: 60px;
        background-color: #f5f5f5;
    }
    </style>
</head>
<body>
@yield('nav_section')
@yield('jumbo_section')
<?php
if(Session::has('message')){
    echo '<div id="flash" title="Info">
  <strong>Info!</strong> '.Session::get('message').'</div>';
} else if(Session::has('flash_error')) {
    echo '<div id="flash" title="Error">
  <strong>Error!!!</strong> '.Session::get('flash_error').'</div>';
}
?>
<div class="container">
@yield('content')
</div>
<hr />
<footer class="footer">
    <div class="container">
        <p class="text-muted">
            Copyright &copy; 2014 TopUp. All rights reserved.<br />
            privacy notice / terms and conditions
        </p>
    </div>
</footer>
@yield('js_body_section')
<?php
if(Session::has('message') || Session::has('flash_error')){
    echo '<script lang="javascript">
    $("#flash").dialog({
  open: function( event, ui ) {setTimeout("$(\'#flash\').dialog(\'close\')",3000);}
});
</script>';
}
?>
</body>
</html>