@extends('admin_all')

@section('jumbo_section')
<div id="dlgService"style="font-size:10pt;" title="Service">
    <div class="col-md-12">
        <form id="frmService" class="form-horizontal" role="form" method="POST" action="/frm/admin/all/services">
            <input type="hidden" class="form-control" id="action" name="action" />
            <input type="hidden" class="form-control" id="cId" name="serviceId" />
            <div class="form-group">
                <label class="control-label col-sm-4" for="serviceName">Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="cName" name="serviceName" placeholder="Service name" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="cdesc" required>Description:</label>
                <div class="col-sm-8">
                    <textarea class="form-control" rows="5" id="cDesc" name="serviceDesc" placeholder="Service description"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="apiUrl">API URL:</label>
                <div class="col-sm-8">
                    <input type="url" class="form-control" id="apiUrl" name="serviceApiURL" placeholder="Service API Url" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="cmId" required>Company:</label>
                <div class="col-sm-8">
                    <select class="form-control" id="cmId" name="companyId">
                        @foreach ($companies as $company)
                        <option value="{{ $company['companyId'] }}">{{ $company['companyName'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="ctId" required>Category:</label>
                <div class="col-sm-8">
                    <select class="form-control" id="ctId" name="categoryId">
                        @foreach ($categories as $category)
                        <option value="{{ $category['categoryId'] }}">{{ $category['categoryName'] }}</option>
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
            <h2 class="sub-header">Services</h2>
            <div class="table-responsive">
                <button id="add" type="button" class="btn btn-default">Add</button>
                <button id="edit" type="button" class="btn btn-default" disabled>Edit</button>
                <button id="del" type="button" class="btn btn-default" disabled>Delete</button>
                <table id="grid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="false" data-row-select="true" data-keep-selection="true">
                    <thead>
                        <tr>
                            <th data-column-id="serviceId" data-identifier="true" data-type="numeric" data-align="right" data-width="5%">ID</th>
                            <th data-column-id="company_companyName" data-align="center" data-header-align="center" data-width="10%">Company</th>
                            <th data-column-id="category_categoryName" data-align="center" data-header-align="center" data-width="10%">Category</th>
                            <th data-column-id="serviceName" data-order="asc" data-align="center" data-header-align="center" data-width="10%" searchable="true">Service</th>
                            <th data-column-id="serviceDesc" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="25%">Description</th>
                            <th data-column-id="serviceApiURL" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="20%">API Url</th>
                            <th data-column-id="serviceDate" data-formatter="link" data-sortable="false" data-width="20%">Date</th>
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
        url: "/api/admin/services",
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

    var dlgAddService = $( "#dlgService" ).dialog({autoOpen: false});
    var dlgEditService = $( "#dlgService" ).dialog({autoOpen: false});
    
    $("#add").on("click", function () {       
        $( "#dlgService").find("#cName").removeAttr("disabled");
        $( "#dlgService").find("#cDesc").removeAttr("disabled");
        $( "#dlgService").find("#apiUrl").removeAttr("disabled");
        $( "#dlgService").find("#cmId").removeAttr("disabled");
        $( "#dlgService").find("#ctId").removeAttr("disabled");

        $( "#dlgService").find("#action").val("add");
        $( "#dlgService").find("#cId").val("");
        $( "#dlgService").find("#cName").val("");
        $( "#dlgService").find("#cDesc").val("");
        $( "#dlgService").find("#apiUrl").val("");
        $( "#dlgService").find("#cmId").val(1);
        $( "#dlgService").find("#ctId").val(1);
        $( "#dlgService").find("#msg").html("");
        
        dlgAddService = $( "#dlgService" ).dialog({
            title: "Add Service",
            autoOpen: false, 
            modal: true,
            buttons: {
                Add: function() {
                    $("#frmService").submit();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            height: 450,
            width: 400
        });
        dlgAddService.dialog( "open" );
        $("#frmService").validate();
    });
    
    $("#edit").on("click", function () {
        var selRows = $("#grid").bootgrid("getSelectedRows");
        if(selRows.length > 0) {
            var indx = selRows[0];
            var selIndx = $("#grid").bootgrid("getCurrentRows").propValues("serviceId").indexOf(indx);
            var cmpy = $("#grid").bootgrid("getCurrentRows")[selIndx];
            
            $( "#dlgService").find("#cName").removeAttr("disabled");
            $( "#dlgService").find("#cDesc").removeAttr("disabled");
            $( "#dlgService").find("#apiUrl").removeAttr("disabled");
            $( "#dlgService").find("#cmId").removeAttr("disabled");
            $( "#dlgService").find("#ctId").removeAttr("disabled");
            
            $( "#dlgService").find("#action").val("edit");
            $( "#dlgService").find("#cId").val(cmpy.serviceId);
            $( "#dlgService").find("#cName").val(cmpy.serviceName);
            $( "#dlgService").find("#cDesc").val(cmpy.serviceDesc);
            $( "#dlgService").find("#apiUrl").val(cmpy.serviceApiURL);
            $( "#dlgService").find("#cmId").val(cmpy.company_companyId);
            $( "#dlgService").find("#ctId").val(cmpy.category_categoryId);
            $( "#dlgService").find("#msg").html("");
        }
        
        dlgEditService = $( "#dlgService" ).dialog({
            title: "Edit Service",
            autoOpen: false, 
            modal: true,
            buttons: {
                Edit: function() {
                    $("#frmService").submit();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            height: 450,
            width: 400
        });
        dlgEditService.dialog( "open" );
    });
    
    $("#del").on("click", function () {
        var selRows = $("#grid").bootgrid("getSelectedRows");
        if(selRows.length > 0) {
            var indx = selRows[0];
            var selIndx = $("#grid").bootgrid("getCurrentRows").propValues("serviceId").indexOf(indx);
            var cmpy = $("#grid").bootgrid("getCurrentRows")[selIndx];
            
            $( "#dlgService").find("#cName").attr("disabled", true);
            $( "#dlgService").find("#cDesc").attr("disabled", true);
            $( "#dlgService").find("#apiUrl").attr("disabled", true);
            $( "#dlgService").find("#cmId").attr("disabled", true);
            $( "#dlgService").find("#ctId").attr("disabled", true);
            
            $( "#dlgService").find("#action").val("delete");
            $( "#dlgService").find("#cId").val(cmpy.serviceId);
            $( "#dlgService").find("#cName").val(cmpy.serviceName);
            $( "#dlgService").find("#cDesc").val(cmpy.serviceDesc);
            $( "#dlgService").find("#apiUrl").val(cmpy.serviceApiURL);
            $( "#dlgService").find("#cmId").val(cmpy.company_companyId);
            $( "#dlgService").find("#ctId").val(cmpy.category_categoryId);
            $( "#dlgService").find("#msg").html("Are you sure, you want to delete service?");
        }
        
        dlgDelService = $( "#dlgService" ).dialog({
            title: "Delete Service",
            autoOpen: false, 
            modal: true,
            buttons: {
                Confirm: function() {
                    $("#frmService").submit();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            height: 480,
            width: 400
        });
        dlgDelService.dialog( "open" );
    });
});
</script>
@stop
