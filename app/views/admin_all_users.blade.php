@extends('admin_all')

@section('jumbo_section')
<div id="dlgUser"style="font-size:9pt;" title="User">
    <form id="frmUser" class="form-horizontal" role="form" method="POST" action="/frm/admin/all/users">
        <input type="hidden" class="form-control" id="action" name="action" />
        <input type="hidden" class="form-control" id="uId" name="userId" />
        <input type="hidden" class="form-control" id="uRole" name="userRole" value="user" />
        <div class="form-group">
            <label class="control-label col-sm-4" for="fname">First Name:</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" id="fname" name="userFirstName" placeholder="Enter first name" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="lname">Last Name:</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" id="lname" name="userLastName" placeholder="Enter last name" required>
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
                <input type="text" class="form-control input-sm" id="dob" name="userBirthDate" placeholder="Date of Birth" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="addr">Address:</label>
            <div class="col-sm-8">
                <textarea class="form-control input-sm" rows="4" id="addr" name="userAddress" placeholder="Address"></textarea>
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
    </form>
    <hr />
    <div class="col-sm-12" id="msg"></div>
</div>
@stop

@section('admin_content')
            <h2 class="sub-header">Users</h2>
            <div class="table-responsive">
                <button id="add" type="button" class="btn btn-default">Add</button>
                <button id="edit" type="button" class="btn btn-default" disabled>Edit</button>
                <button id="del" type="button" class="btn btn-default" disabled>Delete</button>
                <table id="grid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="false" data-row-select="true" data-keep-selection="true" style="font-size: 9pt">
                    <thead>
                        <tr>
                            <th data-column-id="userId" data-identifier="true" data-type="numeric" data-align="right" data-width="3%">ID</th>
                            <th data-column-id="userLogin" data-order="asc" data-align="center" data-header-align="center" data-width="8%" searchable="true">Login</th>
                            <th data-column-id="userFirstName" data-order="asc" data-align="center" data-header-align="center" data-width="8%">First Name</th>
                            <th data-column-id="userLastName" data-order="asc" data-align="center" data-header-align="center" data-width="8%">Last Name</th>
                            <th data-column-id="userEmail" data-order="asc" data-align="center" data-header-align="center" data-width="13%">Email</th>
                            <th data-column-id="userGender" data-order="asc" data-align="center" data-header-align="center" data-width="10%">Gender</th>
                            <th data-column-id="country_countryName" data-order="asc" data-align="center" data-header-align="center" data-width="10%">Country</th>
                            <th data-column-id="userBirthDate" data-formatter="link" data-sortable="false" data-width="10%">Birth Date</th>
                            <th data-column-id="userRegDate" data-formatter="link" data-sortable="false" data-width="20%">Reg Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
@stop


@section('js_body_section')
<script lang="javascript">
function getSelectedRow() {
    var selRows = $("#grid").bootgrid("getSelectedRows");
    if(selRows.length === 0) return null;
    var indx = selRows[0];
    var selIndx = $("#grid").bootgrid("getCurrentRows").propValues("userId").indexOf(indx);
    var obj = $("#grid").bootgrid("getCurrentRows")[selIndx];
    return obj;
}

function prepareDialog(bDisable) {
    if(bDisable === true) {
        $( "#dlgUser").find("#fname").attr("disabled", true);
        $( "#dlgUser").find("#lname").attr("disabled", true);
        $( "#dlgUser").find("#login").attr("disabled", true);
        $( "#dlgUser").find("#email").attr("disabled", true);
        $( "#dlgUser").find("#pwd").attr("disabled", true);
        $( "#dlgUser").find("#phone").attr("disabled", true);
        $( "#dlgUser").find("#phoneType").attr("disabled", true);
        $( "#dlgUser").find("#btnAddPhone").attr("disabled", true);
        $( "#dlgUser").find("#genderM").attr("disabled", true);
        $( "#dlgUser").find("#genderF").attr("disabled", true);
        $( "#dlgUser").find("#dob").attr("disabled", true);
        $( "#dlgUser").find("#addr").attr("disabled", true);
        $( "#dlgUser").find("#cnId").attr("disabled", true);
        $( "#dlgUser").find(".remove-phone").parents("div.form-group").remove();
    } else {
        $( "#dlgUser").find("#fname").removeAttr("disabled");
        $( "#dlgUser").find("#lname").removeAttr("disabled");
        $( "#dlgUser").find("#login").removeAttr("disabled");
        $( "#dlgUser").find("#email").removeAttr("disabled");
        $( "#dlgUser").find("#pwd").removeAttr("disabled");
        $( "#dlgUser").find("#phone").removeAttr("disabled");
        $( "#dlgUser").find("#phoneType").removeAttr("disabled");
        $( "#dlgUser").find("#btnAddPhone").removeAttr("disabled");
        $( "#dlgUser").find("#genderM").removeAttr("disabled");
        $( "#dlgUser").find("#genderF").removeAttr("disabled");
        $( "#dlgUser").find("#dob").removeAttr("disabled");
        $( "#dlgUser").find("#addr").removeAttr("disabled");
        $( "#dlgUser").find("#cnId").removeAttr("disabled");
        $( "#dlgUser").find(".remove-phone").parents("div.form-group").remove();
    }
}
function populateDialog(action, usr) {
    $( "#dlgUser").find("#action").val(action);
    if(action === "add") {
        $( "#dlgUser").find("#uId").val("");
        $( "#dlgUser").find("#fname").val("");
        $( "#dlgUser").find("#lname").val("");
        $( "#dlgUser").find("#login").val("");
        $( "#dlgUser").find("#email").val("");
        $( "#dlgUser").find("#pwd").val("changeme");
        $( "#dlgUser").find("#phoneId").val("0");
        $( "#dlgUser").find("#phone").val("");
        $( "#dlgUser").find("#genderM").parent().trigger('click');
        $( "#dlgUser").find("#dob").val("");
        $( "#dlgUser").find("#addr").val("");
        $( "#dlgUser").find("#cnId").val(1);
        $( "#dlgUser").find("#msg").html("");
        $( "#dlgUser").find("#pwd").attr("required", true);
    } else {
        $( "#dlgUser").find("#action").val(action);
        $( "#dlgUser").find("#uId").val(usr.userId);
        $( "#dlgUser").find("#fname").val(usr.userFirstName);
        $( "#dlgUser").find("#lname").val(usr.userLastName);
        $( "#dlgUser").find("#login").val(usr.userLogin);
        $( "#dlgUser").find("#email").val(usr.userEmail);
        $( "#dlgUser").find("#pwd").val(usr.userPassword);
        $( "#dlgUser").find("#phone").val("");
        $( "#dlgUser").find((usr.userGender==="male"?"#genderM": "#genderF")).parent().trigger('click');
        $( "#dlgUser").find("#dob").val(usr.userBirthDate);
        $( "#dlgUser").find("#addr").val(usr.userAddress);
        $( "#dlgUser").find("#cnId").val(usr.country_countryId);
        $( "#dlgUser").find("#msg").html("");
        $( "#dlgUser").find("#pwd").removeAttr("required");
    }
    var dlgUser = $( "#dlgUser" ).dialog({
        title: action+" user",
        autoOpen: false, 
        modal: true,
        buttons: {
            Submit: function() {
                $("#frmUser").submit();
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        },
        height: 640,
        width: 400
    });
    return dlgUser;
}
function populatePhones(phones) {
    console.log(phones);
    $(phones).each(function(index, ph) {
        if(index === 0) {
            $( "#dlgUser").find("#phoneId").val(ph.userPhoneId);
            $( "#dlgUser").find("#phone").val(ph.userPhoneNo);
            $( "#dlgUser").find("#phoneType").val(ph.userPhoneType);
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

    $("#grid").bootgrid({
        ajax: true,
        url: "/api/admin/users?role=user",
        ajaxSettings: {
            method: "GET",
            cache: false
        },
        searchSettings: {
            delay: 250,
            characters: 3
        },
        requestHandler: function (request) {
            if(request.searchPhrase) {
                request.search = request.searchPhrase;
            }
            return request;
        },
        selection: true,
        multiSelect: false
    }).on("selected.rs.jquery.bootgrid", function(e, rows)
    {
        $("#edit").removeAttr("disabled");
        $("#del").removeAttr("disabled");
    }).on("deselected.rs.jquery.bootgrid", function(e, rows)
    {
        $("#edit").attr("disabled", true);
        $("#del").attr("disabled", true);
    });

    var dlgUser = $( "#dlgUser" ).dialog({autoOpen: false});
    
    
    $("#add").on("click", function () {       
        prepareDialog(false);
        x = 0;
        var dlgAddUser = populateDialog("add", null);
        dlgAddUser.dialog( "open" );
        $("#frmUser").validate({
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
    
    $("#edit").on("click", function () {
        var usr = getSelectedRow();
        if(usr === null) {
            alert("Please select any user");
        } else {
            x = 0;
            prepareDialog(false);
            var dlgEditUser = populateDialog("edit", usr);

            $.get("/api/admin/users/"+usr.userId+"/phones", function(data, status){
                phones = JSON.parse(data);
                if(phones.rows.length > 0) {
                    populatePhones(phones.rows);
                }

                dlgEditUser.dialog( "open" );
                $("#frmUser").validate({
                    rules: {
                        userLogin: {
                            required: true,
                            rangelength: [3, 15]
                        },
                        userPassword: {
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
        }
    });
    
    $("#del").on("click", function () {
        var usr = getSelectedRow();
        if(usr === null) {
            alert("Please select any user");
        } else {
            x = 0;
            prepareDialog(true);
            var dlgDelUser = populateDialog("delete", usr);
            $( "#dlgUser").find("#msg").html("Are you sure, you want to delete user?");

            $.get("/api/admin/users/"+usr.userId+"/phones", function(data, status){
                phones = JSON.parse(data);
                if(phones.rows.length > 0) {
                    populatePhones(phones.rows);
                    $( ".phones" ).attr("disabled", true);
                    $( ".phoneTypes" ).attr("disabled", true);
                    $( ".remove-phone" ).attr("disabled", true);
                }

                dlgDelUser.dialog( "open" );
                $("#frmUser").validate();
            });
        }
    });
    
    $("#del1").on("click", function () {
        var selRows = $("#grid").bootgrid("getSelectedRows");
        if(selRows.length > 0) {
            var indx = selRows[0];
            var selIndx = $("#grid").bootgrid("getCurrentRows").propValues("userId").indexOf(indx);
            var cmpy = $("#grid").bootgrid("getCurrentRows")[selIndx];
            
            prepareDialog(true);
            x = 0;
            
            $( "#dlgUser").find("#action").val("delete");
            $( "#dlgUser").find("#uId").val(cmpy.userId);
            $( "#dlgUser").find("#fname").val(cmpy.userFirstName);
            $( "#dlgUser").find("#lname").val(cmpy.userLastName);
            $( "#dlgUser").find("#login").val(cmpy.userLogin);
            $( "#dlgUser").find("#email").val(cmpy.userEmail);
            $( "#dlgUser").find("#pwd").val(cmpy.userPassword);
            $( "#dlgUser").find("#phone").val("");
            $( "#dlgUser").find((cmpy.userGender==="male"?"#genderM": "#genderF")).parent().trigger('click');
            $( "#dlgUser").find("#dob").val(cmpy.userBirthDate);
            $( "#dlgUser").find("#addr").val(cmpy.userAddress);
            $( "#dlgUser").find("#cnId").val(cmpy.country_countryId);
            $( "#dlgUser").find("#msg").html("Are you sure, you want to delete user?");
        }
        
        dlgDelUser = $( "#dlgUser" ).dialog({
            title: "Delete User",
            autoOpen: false, 
            modal: true,
            buttons: {
                Confirm: function() {
                    $("#frmUser").submit();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            height: 660,
            width: 400
        });
        dlgDelUser.dialog( "open" );
    });
});
</script>
@stop
