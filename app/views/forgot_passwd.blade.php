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
        <h2>Forgot Password</h2>
        <form id="frmForgotPwd" class="form-horizontal" role="form" method="POST" action="/frm/forgotpwd">
            <div class="form-group">
                Please enter your email.
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Email:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="submit" type="submit" value="Send Reset Link" class="btn btn-default">
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('js_body_section')
<script lang="javascript">
    $("#frmForgotPwd").validate();
</script>
@stop
