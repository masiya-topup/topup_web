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
        <h2>Reset Password</h2>
        <form id="frmForgotPwd" class="form-horizontal" role="form" method="POST" action="/frm/password/reset">
            <div class="form-group">
                Please enter your password.
            </div>
            <input type="hidden" class="form-control input-sm" name="token" value="{{ $token }}" required>
            <div class="form-group">
                <label class="control-label col-sm-4" for="newPwd">New Password:</label>
                <div class="col-sm-8"> 
                    <input type="password" class="form-control input-sm" id="newPwd" name="newPwd" placeholder="Enter new password" value="" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="confirmPwd">Confirm Password:</label>
                <div class="col-sm-8"> 
                    <input type="password" class="form-control input-sm" id="confirmPwd" name="confirmPwd" placeholder="Confirm password" value="" required>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="submit" type="submit" value="Reset Password" class="btn btn-default">
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('js_body_section')
<script lang="javascript">
    $("#frmForgotPwd").validate({
        rules: {
            newPwd: { 
                required: true,
                minlength: 6,
                maxlength: 16
            },
            confirmPwd: { 
                equalTo: "#newPwd",
                minlength: 6,
                maxlength: 16
            }
        }
    });
</script>
@stop
