@extends('user_profile')

@section('js_head_section')
{{ HTML::script('js/_lib/validate/jquery.validate.js') }}
{{ HTML::script('js/_lib/validate/additional-methods.js') }}
@stop

@section('jumbo_section')
@stop

@section('user_content')
            <h2 class="sub-header">Account Details</h2>
            <div class="row">
                <form id="frmUserData" class="form-horizontal" role="form" method="POST" action="/frm/user/update">
                    <input type="hidden" class="form-control" id="action" name="action" value="edit" />
                    <input type="hidden" class="form-control" id="uId" name="userId" value="{{{ $user['userId'] }}}" />
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="fname">First Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" id="fname" name="userFirstName" placeholder="Enter first name" value="{{{ $user['userFirstName'] }}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="lname">Last Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" id="lname" name="userLastName" placeholder="Enter last name" value="{{{ $user['userLastName'] }}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="login">Login:</label>
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control input-sm" id="login" name="userLogin" placeholder="User name" value="{{{ $user['userLogin'] }}}" required>
                            {{{ $user['userLogin'] }}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="email">Email:</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control input-sm" id="email" name="userEmail" placeholder="Enter email" value="{{{ $user['userEmail'] }}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="pwdOld">Password (Old):</label>
                        <div class="col-sm-8"> 
                            <input type="password" class="form-control input-sm pwdGroup" id="pwdOld" name="userPasswordOld" placeholder="Enter old password" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="pwdNew">Password (New):</label>
                        <div class="col-sm-8"> 
                            <input type="password" class="form-control input-sm pwdGroup" id="pwdNew" name="userPasswordNew" placeholder="Enter new password" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="control-label col-sm-4">Phone:</label>
                        <div class="col-sm-4">
                            <input type="hidden" id="phoneId" name="userPhoneId[]" value="{{{ (count($phones)>0? $phones[0]['userPhoneId']: '0') }}}">
                            <input type="number" class="form-control input-sm" id="phone" name="userPhone[]" placeholder="Phone: 965XXXXXXXX" value="{{{ (count($phones)>0? $phones[0]['userPhoneNo']: '') }}}" required>
                        </div>
                        <div class="col-sm-4" style="padding: 0px;">
                            <select class="form-control input-sm" id="phoneType" name="userPhoneType[]" style="width:80px; display: inline-block">
                                <option value="prepaid" {{{ (count($phones)>0 && $phones[0]['userPhoneType']=='prepaid'? 'selected': '') }}}>Prepaid</option>
                                <option value="postpaid" {{{ (count($phones)>0 && $phones[0]['userPhoneType']=='postpaid'? 'selected': '') }}}>Postpaid</option>
                            </select>
                            <button id="btnAddPhone" type="button" class="btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                    <div id="dvNewPhones"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="type">Gender:</label>
                        <div class="col-sm-8">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default btn-sm active" for="genderM">
                                    <input type="radio" name="userGender" id="genderM" value="male" checked>Male
                                </label>
                                <label class="btn btn-default btn-sm" for="genderF">
                                    <input type="radio" name="userGender" id="genderF" value="female">Female
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="dob">Birth Date:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" id="dob" name="userBirthDate" value="{{{ $user['userBirthDate'] }}}" placeholder="Date of Birth" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="addr">Address:</label>
                        <div class="col-sm-8">
                            <textarea class="form-control input-sm" rows="4" id="addr" name="userAddress" value="{{{ $user['userAddress'] }}}" placeholder="Address"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="country" required>Country:</label>
                        <div class="col-sm-8">
                            <select class="form-control input-sm" id="cnId" name="countryId">
                                @foreach ($countries as $country)
                                <option value="{{ $country['countryId'] }}">{{ $country['countryName'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <div class="col-sm-offset-2 col-sm-4">
                            <input type="submit" value="Submit" class="btn btn-default submit">
                        </div>
                    </div>
                </form>
            </div>
@stop


@section('js_body_section')
<script lang="javascript">
function populateData() {
    $("#uId").val("{{{ $user['userId'] }}}");
    $("#fname").val("{{{ $user['userFirstName'] }}}");
    $("#lname").val("{{{ $user['userLastName'] }}}");
    $("#login").val("{{{ $user['userLogin'] }}}");
    $("#email").val("{{{ $user['userEmail'] }}}");
    $("#pwdOld").val("");
    //$("#phone").val("");
    $("{{{ ($user['userGender']=='male'?'#genderM':'#genderF') }}}").parent().trigger('click');
    $("#dob").val("{{{ $user['userBirthDate'] }}}");
    $("#addr").val("{{{ $user['userAddress'] }}}");
    $("#cnId").val("{{{ $user['country']->countryId }}}");
    $("#msg").html("");
    $("#pwd").removeAttr("required");
}
function populatePhones(phones) {
    phones = <?php echo json_encode($phones); ?>;
    console.log(phones);
    $(phones).each(function(index, ph) {
        if(index === 0) {
            $("#phoneId").val(ph.userPhoneId);
            $("#phone").val(ph.userPhoneNo);
            $("#phoneType").val(ph.userPhoneType);
        } else {
            $(btnAddPhone).trigger("click");
            $( ".phoneId" ).last().val(ph.userPhoneId);
            $( ".phones" ).last().val(ph.userPhoneNo);
            $( ".phoneTypes" ).last().val(ph.userPhoneType);
        }
    });
}
$().ready(function() {
    jQuery.validator.addMethod("phoneKuwait", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, ""); 
            return this.optional(element) || phone_number.length > 9 &&
                    phone_number.match(/^965[0-9]{8}$/);
    }, "Invalid phone number (format: 965XXXXXXXX)");
    
    $( "#dob" ).datepicker({
      defaultDate: "-1w",
      dateFormat: 'yy-mm-dd',
      maxDate: "0",
      changeMonth: true,
      changeYear: true,
      numberOfMonths: 1
    });
    $('#dob').datepicker("setDate", "-1w" );

    var maxPhones      = 4; //maximum input boxes allowed
    var dvNewPhones    = $("#dvNewPhones"); //Fields wrapper
    var btnAddPhone    = $("#btnAddPhone");
    
    var x = 1; //initlal text box count
    $(btnAddPhone).click(function(e) {
        e.preventDefault();
        if(x < maxPhones){
            x++;
            $(dvNewPhones).append('<div class="form-group"> \
                <div class="col-sm-4">&nbsp;</div> \
                <div> \
                    <div class="col-sm-4"> \
                        <input type="hidden" class="phoneId" name="userPhoneId[]"> \
                        <input type="number" class="form-control input-sm phones" name="userPhone[]" placeholder="Phone" required> \
                    </div> \
                    <div class="col-sm-4" style="padding: 0px;"> \
                        <select class="form-control input-sm phoneTypes" name="userPhoneType[]" style="width:80px; display: inline-block"> \
                            <option value="prepaid">Prepaid</option> \
                            <option value="postpaid">Postpaid</option> \
                        </select> \
                        <button type="button" class="btn btn-default btn-xs remove-phone"> \
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> \
                        </button> \
                    </div> \
                </div> \
            </div>');
        }
    });
    
    $(dvNewPhones).on("click",".remove-phone", function(e){
        e.preventDefault(); $(this).parents('div.form-group').remove(); x--;
    });

    populateData();
    populatePhones();

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
    $("#frmUserData").validate({
        rules: {
            userPasswordOld: {
                skip_or_fill_minimum: [2,".pwdGroup"]
            },
            userPasswordNew: {
                skip_or_fill_minimum: [2,".pwdGroup"]
            },
            userLogin: {
                required: true,
                rangelength: [3, 15]
            },
            userPassword: {
                required: true,
                rangelength: [8, 16]
            },
            'userPhone[]': {
                phoneKuwait:true,
                digits: true,
                rangelength: [11, 11]
            },
            userBirthDate: {
                required: true,
                date: true
            }
        }
    });
});
</script>
@stop
