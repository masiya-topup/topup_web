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
        @if(Session::has('topup') || isset($topup))
        <h2>Topup Transaction <span class="label label-{{ ($result['transactionStatus']=="success"?"success":"danger") }}">{{$result['transactionStatus']}}</span></h2>
        @else
        <h2>Topup Transaction <span class="label label-info">{{$result['transactionStatus']}}</span></h2>
        @endif
        <div class="row">
            <div class="col-sm-6">Result</div>
            <div class="col-sm-6"><p class="bg-{{ ($result['transactionStatus']=="success"?"success":"danger") }}">{{ $result['transactionStatus'] }}</p></div>
        </div>
        <div class="row">
            <div class="col-sm-6">TrackId</div>
            <div class="col-sm-6">{{ $result['transactionTrackId'] }}</div>
        </div>
        <div class="row">
            <div class="col-sm-6">RefId</div>
            <div class="col-sm-6">{{ $result['transactionRefId'] }}</div>
        </div>
        <div class="row">
            <div class="col-sm-6">PaymentId</div>
            <div class="col-sm-6">{{ $result['transactionPaymentId'] }}</div>
        </div>
        <div class="row">
            <div class="col-sm-6">Amount</div>
            <div class="col-sm-6">{{ $result['transactionAmount'] }} KD</div>
        </div>
        <div class="row">
            <div class="col-sm-6">Date</div>
            <div class="col-sm-6">{{ $result['transactionDate'] }}  </div>
        </div>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-md-4">&nbsp;</div>
    <div class="col-md-8">
        @if(Session::has('userLogin'))
        <div class="row">
            <div class="col-sm-6"><a class="btn btn-info col-sm-6" href="/user/profile/topup">Topup Again</a></div>
            <div class="col-sm-6"><a class="btn btn-primary col-sm-6" href="/user/profile">My Profile</a></div>
        </div>
        @else
        <div class="row">
            <div class="col-sm-6"><a class="btn btn-info col-sm-6" href="/topup">Topup Again</a></div>
            <div class="col-sm-6"><a class="btn btn-primary col-sm-6" href="/">Home</a></div>
        </div>
        @endif
    </div>
</div>
@stop


@section('js_body_section')
@stop
