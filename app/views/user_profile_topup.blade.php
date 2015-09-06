@extends('user_profile')

@section('js_head_section')
{{ HTML::script('js/_lib/validate/jquery.validate.js') }}
@stop

@section('jumbo_section')
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

@section('user_content')
            <h2 class="sub-header">Topup</h2>
            <div class="row">
                <form id="frmTopup" class="form-horizontal" role="form" method="POST" action="/frm/phone/topup">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="service">Service:</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="service" name="service">
                                @foreach ($services as $service)
                                <option value="{{ $service['serviceId'] }}">{{ $service['company']['companyName'] }} > {{ $service['category']['categoryName'] }} > {{ $service['serviceName'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="phoneNo">Phone:</label>
                        <div class="col-sm-8">
                            @if (count($phones) > 0)
                            <select class="form-control" id="phoneId" name="phoneId">
                                <option value="0">-- Use New --</option>
                                @foreach ($phones as $phone)
                                <option value="{{ $phone['userPhoneId'] }}">{{ $phone['userPhoneNo'] }} | {{ $phone['userPhoneType'] }}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phoneNo" class="control-label col-sm-2">&nbsp;</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="phoneNo" name="phoneNo" placeholder="Phone: 965XXXXXXXX" required>
                        </div>
                        <div class="col-sm-4" style="padding: 0px;">
                            <select class="form-control" id="phoneType" name="phoneType" style="width:80px; display: inline-block">
                                <option value="prepaid">Prepaid</option>
                                <option value="postpaid">Postpaid</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Email:</label>
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" id="email" name="email" value="{{ $user['userEmail']}}">
                            {{ $user['userEmail']}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="amount">Amount:</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount (in KD)" min="1" max="200" required>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" value="Topup" class="btn btn-default">
                        </div>
                    </div>
                </form>
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

    $( "#phoneId" ).change(function() {
        if($( "#phoneId" ).val() == "0") {
            $( "#phoneNo" ).val("");
            $( "#phoneNo" ).attr("required", true);
            $( "#phoneNo" ).removeAttr("disabled");
            $( "#phoneType" ).removeAttr("disabled");
        } else {
            var arr = $( "#phoneId" ).find("option:selected").text().split(" | ");
            $( "#phoneNo" ).val(arr[0]);
            $( "#phoneType" ).val(arr[1]);
            $( "#phoneNo" ).attr("disabled", true);
            $( "#phoneType" ).attr("disabled", true);
            $( "#phoneNo" ).removeAttr("required");
        }
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
