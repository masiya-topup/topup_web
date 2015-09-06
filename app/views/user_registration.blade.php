@extends('layout.master')

@section('css_head_section')
@stop

@section('js_head_section')
{{ HTML::script('js/_lib/validate/jquery.validate.js') }}
@stop


@section('nav_section')
@include('navbar', ['page' => 'registration'])
@stop

@section('jumbo_section')
<div class="jumbotron">
    <div class="container">&nbsp;</div>
    @if(Session::has('prevData'))
    <?php $prevData = Session::get('prevData'); ?>
    @else
    <?php $prevData = array('userFirstName' => '',
                            'userLastName' => '',
                            'userBirthDate' => '',
                            'userAddress' => '',
                            'userGender' => 'male',
                            'country' => array('countryId' => '')); ?>
    @endif
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-2">
        <!--img src="http://topup:8080/topup/images/home/img1.jpg"-->
    </div>
    <div class="col-md-8">
        <h2>Registration</h2>
        <form id="frmUserReg" class="form-horizontal" role="form" method="POST" action="/frm/user/register">
            <input type="hidden" class="form-control" id="uRole" name="userRole" value="user" />
            <div class="form-group">
                <label class="control-label col-sm-4" for="fname">First Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="fname" name="userFirstName" placeholder="Enter first name" value="{{ $prevData['userFirstName'] }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="lname">Last Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="lname" name="userLastName" placeholder="Enter last name" value="{{ $prevData['userLastName'] }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="login">Login:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="login" name="userLogin" placeholder="User name" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="email">Email:</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control input-sm" id="email" name="userEmail" placeholder="Enter email" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="pwd">Password:</label>
                <div class="col-sm-8"> 
                    <input type="password" class="form-control input-sm" id="pwd" name="userPassword" placeholder="Enter password" value="changeme" required>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail" class="control-label col-sm-4">Phone:</label>
                <div class="col-sm-4">
                    <input type="hidden" id="phoneId" name="userPhoneId[]" value="0">
                    <input type="number" class="form-control input-sm" id="phone" name="userPhone[]" placeholder="965XXXXXXXX" required>
                </div>
                <div class="col-sm-4" style="padding: 0px;">
                    <select class="form-control input-sm" id="phoneType" name="userPhoneType[]" style="width:80px; display: inline-block">
                        <option value="prepaid">Prepaid</option>
                        <option value="postpaid">Postpaid</option>
                    </select>
<!--                    <button id="btnAddPhone" type="button" class="btn btn-default btn-xs">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>-->
                </div>
            </div>
            <div id="dvNewPhones"></div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="type">Gender:</label>
                <div class="col-sm-8">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default btn-sm {{ ($prevData['userGender']=='male'? 'active': '') }}" for="genderM">
                            <input type="radio" name="userGender" id="genderM" value="male" {{ ($prevData['userGender']=='male'? 'checked': '') }}>Male
                        </label>
                        <label class="btn btn-default btn-sm {{ ($prevData['userGender']=='female'? 'active': '') }}" for="genderF">
                            <input type="radio" name="userGender" id="genderF" value="female" {{ ($prevData['userGender']=='female'? 'checked': '') }}>Female
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="dob">Birth Date:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="dob" name="userBirthDate" placeholder="Date of Birth" value="{{ $prevData['userBirthDate'] }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="addr">Address:</label>
                <div class="col-sm-8">
                    <textarea class="form-control input-sm" rows="4" id="addr" name="userAddress" placeholder="Address">{{ $prevData['userAddress'] }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="country" required>Country:</label>
                <div class="col-sm-8">
                    <select class="form-control input-sm" id="cnId" name="countryId">
                        @foreach ($countries as $country)
                        <option value="{{ $country['countryId'] }}" {{ ($prevData['country']['countryId']==$country['countryId']? 'selected': '') }}>{{ $country['countryName'] }}</option>
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
    <div class="col-md-2">&nbsp;</div>
</div>
@stop

@section('js_body_section')
<script lang="javascript">
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
    $('#dob').datepicker("setDate", "{{ (!empty($prevData['userBirthDate'])? $prevData['userBirthDate']: '-1W') }}" );

    $("#frmAuth").validate({
        rules: {
            username: {
                required: true,
                rangelength: [3, 15]
            },
            password: {
                required: true,
                rangelength: [8, 16]
            }
        }
    });
    $("#frmUserReg").validate({
        rules: {
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
                required: true,
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