@extends('admin_all')

@section('jumbo_section')
<div id="dlgCategory"style="font-size:10pt;" title="Category">
    <div class="col-md-12">
        <form id="frmCategory" class="form-horizontal" role="form" method="POST" action="/frm/admin/all/categories">
            <input type="hidden" class="form-control" id="action" name="action" />
            <input type="hidden" class="form-control" id="cId" name="categoryId" />
            <div class="form-group">
                <label class="control-label col-sm-4" for="categoryName">Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="cName" name="categoryName" placeholder="Category name" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="cdesc" required>Description:</label>
                <div class="col-sm-8">
                    <textarea class="form-control" rows="5" id="cDesc" name="categoryDesc" placeholder="Category description"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="company" required>Company:</label>
                <div class="col-sm-8">
                    <select class="form-control" id="cmId" name="companyId">
                        @foreach ($companies as $company)
                        <option value="{{ $company['companyId'] }}">{{ $company['companyName'] }}</option>
                        @endforeach
                    </select>
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
            <h2 class="sub-header">Categories</h2>
            <div class="table-responsive">
                <button id="add" type="button" class="btn btn-default">Add</button>
                <button id="edit" type="button" class="btn btn-default" disabled>Edit</button>
                <button id="del" type="button" class="btn btn-default" disabled>Delete</button>
                <table id="grid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="false" data-row-select="true" data-keep-selection="true">
                    <thead>
                        <tr>
                            <th data-column-id="categoryId" data-identifier="true" data-type="numeric" data-align="right" data-width="10%">ID</th>
                            <th data-column-id="companyName" data-order="asc" data-align="center" data-header-align="center" data-width="15%" searchable="true">Company Name</th>
                            <th data-column-id="categoryName" data-order="asc" data-align="center" data-header-align="center" data-width="15%" searchable="true">Category Name</th>
                            <th data-column-id="categoryDesc" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="40%">Description</th>
                            <th data-column-id="categoryDate" data-formatter="link" data-sortable="false" data-width="20%">Date</th>
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
        url: "/api/admin/categories",
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

    var dlgAddCategory = $( "#dlgCategory" ).dialog({autoOpen: false});
    var dlgEditCategory = $( "#dlgCategory" ).dialog({autoOpen: false});
    
    $("#add").on("click", function () {       
        $( "#dlgCategory").find("#cName").removeAttr("disabled");
        $( "#dlgCategory").find("#cDesc").removeAttr("disabled");
        $( "#dlgCategory").find("#cmId").removeAttr("disabled");
        $( "#dlgCategory").find("#cnId").removeAttr("disabled");

        $( "#dlgCategory").find("#action").val("add");
        $( "#dlgCategory").find("#cId").val("");
        $( "#dlgCategory").find("#cName").val("");
        $( "#dlgCategory").find("#cDesc").val("");
        $( "#dlgCategory").find("#cmId").val(1);
        $( "#dlgCategory").find("#cnId").val(1);
        $( "#dlgCategory").find("#msg").html("");
        
        dlgAddCategory = $( "#dlgCategory" ).dialog({
            title: "Add Category",
            autoOpen: false, 
            modal: true,
            buttons: {
                Add: function() {
                    $("#frmCategory").submit();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            height: 400,
            width: 400
        });
        dlgAddCategory.dialog( "open" );
        $("#frmCategory").validate();
    });
    
    $("#edit").on("click", function () {
        var selRows = $("#grid").bootgrid("getSelectedRows");
        if(selRows.length > 0) {
            var indx = selRows[0];
            var selIndx = $("#grid").bootgrid("getCurrentRows").propValues("categoryId").indexOf(indx);
            var cmpy = $("#grid").bootgrid("getCurrentRows")[selIndx];
            
            $( "#dlgCategory").find("#cName").removeAttr("disabled");
            $( "#dlgCategory").find("#cDesc").removeAttr("disabled");
            $( "#dlgCategory").find("#cmId").removeAttr("disabled");
            $( "#dlgCategory").find("#cnId").removeAttr("disabled");
            
            $( "#dlgCategory").find("#action").val("edit");
            $( "#dlgCategory").find("#cId").val(cmpy.categoryId);
            $( "#dlgCategory").find("#cName").val(cmpy.categoryName);
            $( "#dlgCategory").find("#cDesc").val(cmpy.categoryDesc);
            $( "#dlgCategory").find("#cmId").val(cmpy.companyId);
            $( "#dlgCategory").find("#cnId").val(cmpy.countryId);
            $( "#dlgCategory").find("#msg").html("");
        }
        
        dlgEditCategory = $( "#dlgCategory" ).dialog({
            title: "Edit Category",
            autoOpen: false, 
            modal: true,
            buttons: {
                Edit: function() {
                    $("#frmCategory").submit();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            height: 400,
            width: 400
        });
        dlgEditCategory.dialog( "open" );
    });
    
    $("#del").on("click", function () {
        var selRows = $("#grid").bootgrid("getSelectedRows");
        if(selRows.length > 0) {
            var indx = selRows[0];
            var selIndx = $("#grid").bootgrid("getCurrentRows").propValues("categoryId").indexOf(indx);
            var cmpy = $("#grid").bootgrid("getCurrentRows")[selIndx];
            
            $( "#dlgCategory").find("#cName").attr("disabled", true);
            $( "#dlgCategory").find("#cDesc").attr("disabled", true);
            $( "#dlgCategory").find("#cmId").attr("disabled", true);
            $( "#dlgCategory").find("#cnId").attr("disabled", true);
            
            $( "#dlgCategory").find("#action").val("delete");
            $( "#dlgCategory").find("#cId").val(cmpy.categoryId);
            $( "#dlgCategory").find("#cName").val(cmpy.categoryName);
            $( "#dlgCategory").find("#cDesc").val(cmpy.categoryDesc);
            $( "#dlgCategory").find("#cmId").val(cmpy.companyId);
            $( "#dlgCategory").find("#cnId").val(cmpy.countryId);
            $( "#dlgCategory").find("#msg").html("Are you sure, you want to delete category?");
        }
        
        dlgDelCategory = $( "#dlgCategory" ).dialog({
            title: "Delete Category",
            autoOpen: false, 
            modal: true,
            buttons: {
                Confirm: function() {
                    $("#frmCategory").submit();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            height: 430,
            width: 400
        });
        dlgDelCategory.dialog( "open" );
    });
});
</script>
@stop
