@extends('layout.master')

@section('css_head_section')
@stop

@section('js_head_section')
{{ HTML::script('js/_lib/validate/jquery.validate.js') }}
@stop

@section('nav_section')
@include('navbar', ['page' => 'topup'])
@stop

@section('jumbo_section')
<div class="jumbotron">
    <div class="container">&nbsp;</div>
</div>
<div id="dlgConfirm" style="font-size:9pt;" title="User">
    <h4>You are about to pay</h4>
    <div class="row">
        <div class="col-md-10">Amount:</div><div class="col-md-2"><span id="idAmount"></span> KD</div>
        <div class="col-md-10">0% Charge:</div><div class="col-md-2"><span id="idCharge">0</span> KD</div>
        <div class="col-md-12">-------------------------------------------------------------------</div>
        <div class="col-md-10">Total:</div><div class="col-md-2"><span id="idTotal"></span> KD</div>
    </div>
    
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <!--img src="http://topup:8080/topup/images/home/img1.jpg"-->
    </div>
    <div class="col-md-8">
        <h2>Topup</h2>
        <form id="frmTopup" class="form-horizontal" role="form" method="POST" action="/frm/phone/topup">
            <div class="form-group">
                <label class="control-label col-sm-2" for="service">Service:</label>
                <div class="col-sm-10">
                    <select class="form-control" id="service" name="service">
                        @foreach ($services as $service)
                        <option value="{{ $service['serviceId'] }}">{{ $service['company']['companyName'] }} > {{ $service['category']['categoryName'] }} > {{ $service['serviceName'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="phoneNo">Phone:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="phoneNo" name="phoneNo" placeholder="Phone: 965XXXXXXXX" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Email:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="type">Type:</label>
                <div class="col-sm-10">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default btn-sm active">
                            <input type="radio" name="phoneType" id="prepaid" value="prepaid" checked>Prepaid
                        </label>
                        <label class="btn btn-default btn-sm">
                            <input type="radio" name="phoneType" id="postpaid" valude="postpaid">Postpaid
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="amount">Amount:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount (in KD)" min="1" max="200" required>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="submit" type="submit" value="Submit" class="btn btn-default">
                </div>
            </div>
        </form>
    </div>
</div>
@stop


@section('js_body_section')
<script lang="javascript">
$().ready(function() {
    var dlgConfirm = $( "#dlgConfirm" ).dialog({
        title: "Confirm Payment",
        autoOpen: false, 
        modal: true,
        open: function() {
            $(this).find("#idAmount").text($(this).data('amount'));
            $(this).find("#idTotal").text($(this).data('amount'));
        },
        buttons: {
            Accept: function() {
                $(this).data('form').submit();
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        },
        height: 240,
        width: 400
    });
    jQuery.validator.addMethod("phoneKuwait", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, ""); 
            return this.optional(element) || phone_number.length > 9 &&
                    phone_number.match(/^965[0-9]{8}$/);
    }, "Invalid phone number (format: 965XXXXXXXX)");
    $("#frmTopup").validate({
        rules: {
            phoneNo: {
                phoneKuwait:true,
                digits: true,
                rangelength: [11, 11]
            }
        },
        submitHandler: function(form) {
            dlgConfirm.data('form', form).data('amount', $("#frmTopup").find("#amount").val()).dialog( "open" );
        }
    });
});
</script>
@stop
