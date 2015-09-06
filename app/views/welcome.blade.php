@extends('layout.master')

@section('css_head_section')
@stop

@section('js_head_section')
{{ HTML::script('js/_lib/validate/jquery.validate.js') }}
@stop

@section('nav_section')
@include('navbar', ['page' => 'home'])
@stop

@section('jumbo_section')
<div class="jumbotron">
    <div class="container">&nbsp;</div>
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <!--img src="http://topup:8080/topup/images/home/img1.jpg"-->
        </div>
        <div class="col-md-8">
          <h2>Register Once</h2>
          <h3>TopUP everytime</h3>
          <p>Top Up allows you to quickly and conveniently recharge any Wataniya mobile phone, whether it’s yours, family or friends; Anytime and Anywhere.</p>
          <p>
              <a class="btn btn-primary" href="/topup" role="button">Topup Now &raquo;</a>
              <a class="btn btn-primary" href="/registration" role="button">Register Now &raquo;</a>
              <a class="btn btn-default" href="#" role="button">How it Works &raquo;</a>
          </p>
        </div>
    </div>
@stop

@section('js_body_section')
<script lang="javascript">
$().ready(function() {

    $("#frmAuth").validate({
        rules: {
            username: {
                required: true,
                rangelength: [3, 15]
            },
            password: {
                required: true,
                rangelength: [4, 16]
            },
        }
    });
});
</script>
@stop