@extends('admin_all')

@section('nav_section')
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Topup</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
@stop

@section('jumbo_section')
<div id="dlgCompany"style="font-size:10pt;" title="Company">
    <div class="col-md-12">
        <form id="frmCompany" class="form-horizontal" role="form" method="POST" action="/frm/admin/all/companies">
            <input type="hidden" class="form-control" id="action" name="action" />
            <input type="hidden" class="form-control" id="cId" name="companyId" />
            <div class="form-group">
                <label class="control-label col-sm-4" for="companyName">Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="cName" name="companyName" placeholder="Company name" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="cdesc" required>Description:</label>
                <div class="col-sm-8">
                    <textarea class="form-control" rows="5" id="cDesc" name="companyDesc" placeholder="Company description"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="country" required>Country:</label>
                <div class="col-sm-8">
                    <select class="form-control" id="cnId" name="countryId">
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
</div>
@stop

@section('admin_content')
            <h2 class="sub-header">Companies</h2>
            <div class="table-responsive">
                <button id="add" type="button" class="btn btn-default">Add</button>
                <button id="edit" type="button" class="btn btn-default" disabled>Edit</button>
                <button id="del" type="button" class="btn btn-default" disabled>Delete</button>
                <table id="grid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="false" data-row-select="true" data-keep-selection="true">
                    <thead>
                        <tr>
                            <th data-column-id="companyId" data-identifier="true" data-type="numeric" data-align="right" data-width="10%">ID</th>
                            <th data-column-id="companyName" data-order="asc" data-align="center" data-header-align="center" data-width="20%" searchable="true">Company Name</th>
                            <th data-column-id="companyDesc" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="50%">Description</th>
                            <th data-column-id="companyDate" data-formatter="link" data-sortable="false" data-width="20%">Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
@stop


@section('js_body_section')
<script lang="javascript">
$().ready(function() {

    $("#grid").bootgrid({
        ajax: true,
        url: "/api/admin/companies",
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

    var dlgAddCompany = $( "#dlgCompany" ).dialog({autoOpen: false});
    var dlgEditCompany = $( "#dlgCompany" ).dialog({autoOpen: false});
    
    $("#add").on("click", function () {       
        $( "#dlgCompany").find("#cName").removeAttr("disabled");
        $( "#dlgCompany").find("#cDesc").removeAttr("disabled");
        $( "#dlgCompany").find("#cnId").removeAttr("disabled");

        $( "#dlgCompany").find("#action").val("add");
        $( "#dlgCompany").find("#cId").val("");
        $( "#dlgCompany").find("#cName").val("");
        $( "#dlgCompany").find("#cDesc").val("");
        $( "#dlgCompany").find("#cnId").val(1);
        $( "#dlgCompany").find("#msg").html("");
        
        dlgAddCompany = $( "#dlgCompany" ).dialog({
            title: "Add Company",
            autoOpen: false, 
            modal: true,
            buttons: {
                Add: function() {
                    $("#frmCompany").submit();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            height: 350,
            width: 400
        });
        dlgAddCompany.dialog( "open" );
        $("#frmCompany").validate();
    });
    
    $("#edit").on("click", function () {
        var selRows = $("#grid").bootgrid("getSelectedRows");
        if(selRows.length > 0) {
            var indx = selRows[0];
            var selIndx = $("#grid").bootgrid("getCurrentRows").propValues("companyId").indexOf(indx);
            var cmpy = $("#grid").bootgrid("getCurrentRows")[selIndx];
            
            $( "#dlgCompany").find("#cName").removeAttr("disabled");
            $( "#dlgCompany").find("#cDesc").removeAttr("disabled");
            $( "#dlgCompany").find("#cnId").removeAttr("disabled");
            
            $( "#dlgCompany").find("#action").val("edit");
            $( "#dlgCompany").find("#cId").val(cmpy.companyId);
            $( "#dlgCompany").find("#cName").val(cmpy.companyName);
            $( "#dlgCompany").find("#cDesc").val(cmpy.companyDesc);
            $( "#dlgCompany").find("#cnId").val(cmpy.countryId);
            $( "#dlgCompany").find("#msg").html("");
        }
        
        dlgEditCompany = $( "#dlgCompany" ).dialog({
            title: "Edit Company",
            autoOpen: false, 
            modal: true,
            buttons: {
                Edit: function() {
                    $("#frmCompany").submit();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            height: 350,
            width: 400
        });
        dlgEditCompany.dialog( "open" );
    });
    
    $("#del").on("click", function () {
        var selRows = $("#grid").bootgrid("getSelectedRows");
        if(selRows.length > 0) {
            var indx = selRows[0];
            var selIndx = $("#grid").bootgrid("getCurrentRows").propValues("companyId").indexOf(indx);
            var cmpy = $("#grid").bootgrid("getCurrentRows")[selIndx];
            
            $( "#dlgCompany").find("#cName").attr("disabled", true);
            $( "#dlgCompany").find("#cDesc").attr("disabled", true);
            $( "#dlgCompany").find("#cnId").attr("disabled", true);
            
            $( "#dlgCompany").find("#action").val("delete");
            $( "#dlgCompany").find("#cId").val(cmpy.companyId);
            $( "#dlgCompany").find("#cName").val(cmpy.companyName);
            $( "#dlgCompany").find("#cDesc").val(cmpy.companyDesc);
            $( "#dlgCompany").find("#cnId").val(cmpy.countryId);
            $( "#dlgCompany").find("#msg").html("Are you sure, you want to delete company?");
        }
        
        dlgDelCompany = $( "#dlgCompany" ).dialog({
            title: "Delete Company",
            autoOpen: false, 
            modal: true,
            buttons: {
                Confirm: function() {
                    $("#frmCompany").submit();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            height: 380,
            width: 400
        });
        dlgDelCompany.dialog( "open" );
    });
});
</script>
@stop
