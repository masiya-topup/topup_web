@extends('admin_customer')

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
<div id="dlgTicket"style="font-size:10pt;" title="Ticket">
    <div class="col-md-12">
        <form id="frmTicket" class="form-horizontal" role="form" method="POST" action="/frm/admin/customer/tickets">
            <input type="hidden" class="form-control" id="action" name="action" />
            <input type="hidden" class="form-control" id="cId" name="ticketId" />
            <div class="form-group">
                <label class="control-label col-sm-4" for="cTitle">Title:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="cTitle" name="ticketTitle" placeholder="Title" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="cDesc" required>Description:</label>
                <div class="col-sm-8">
                    <textarea class="form-control" rows="5" id="cDesc" name="ticketDesc" placeholder="Description"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="cUser">User:</label>
                <div class="col-sm-8">
                    <select class="form-control input-sm" id="cUser" name="userId">
                        @foreach ($users as $user)
                        <option value="{{ $user['userId'] }}">{{ $user['userFirstName']." ".$user['userLastName']." (".$user['userLogin'].")" }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="cStatus" required>Status:</label>
                <div class="col-sm-8">
                    <select class="form-control input-sm" id="cStatus" name="ticketStatus">
                        <option value="new" selected>New</option>
                        <option value="in-progress">In Progress</option>
                        <option value="un-resolved">UnResolved</option>
                        <option value="resolved">Resolved</option>
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
            <h2 class="sub-header">Tickets</h2>
            <div class="table-responsive">
                <button id="add" type="button" class="btn btn-default">Add</button>
                <button id="edit" type="button" class="btn btn-default" disabled>Edit</button>
                <button id="del" type="button" class="btn btn-default" disabled>Delete</button>
                <table id="grid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="false" data-row-select="true" data-keep-selection="true" style="font-size: 9pt">
                    <thead>
                        <tr>
                            <th data-column-id="ticketId" data-identifier="true" data-type="numeric" data-align="right" data-width="5%">ID</th>
                            <th data-column-id="ticketTitle" data-order="asc" data-align="center" data-header-align="center" data-width="15%" searchable="true">Title</th>
                            <th data-column-id="ticketDesc" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="35%">Description</th>
                            <th data-column-id="owner_userLogin" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="10%">Owner</th>
                            <th data-column-id="user_userLogin" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="10%">User</th>
                            <th data-column-id="ticketOpenDate" data-formatter="link" data-sortable="false" data-width="15%">Open Date</th>
                            <th data-column-id="ticketCloseDate" data-formatter="link" data-sortable="false" data-width="15%">Close Date</th>
                            <th data-column-id="ticketStatus" data-formatter="link" data-sortable="false" data-width="5%">Status</th>
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
        url: "/api/admin/tickets",
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

    var dlgAddTicket = $( "#dlgTicket" ).dialog({autoOpen: false});
    var dlgEditTicket = $( "#dlgTicket" ).dialog({autoOpen: false});
    
    $("#add").on("click", function () {       
        $( "#dlgTicket").find("#cTitle").removeAttr("disabled");
        $( "#dlgTicket").find("#cDesc").removeAttr("disabled");
        $( "#dlgTicket").find("#cStatus").removeAttr("disabled");
        $( "#dlgTicket").find("#cUser").removeAttr("disabled");

        $( "#dlgTicket").find("#action").val("add");
        $( "#dlgTicket").find("#cId").val("");
        $( "#dlgTicket").find("#cUser").val($("#cUser option:first").val());
        $( "#dlgTicket").find("#cTitle").val("");
        $( "#dlgTicket").find("#cDesc").val("");
        $( "#dlgTicket").find("#cStatus").val("new");
        $( "#dlgTicket").find("#msg").html("");
        
        dlgAddTicket = $( "#dlgTicket" ).dialog({
            title: "Add Ticket",
            autoOpen: false, 
            modal: true,
            buttons: {
                Add: function() {
                    $("#frmTicket").submit();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            height: 450,
            width: 400
        });
        dlgAddTicket.dialog( "open" );
        $("#frmTicket").validate();
    });
    
    $("#edit").on("click", function () {
        var selRows = $("#grid").bootgrid("getSelectedRows");
        if(selRows.length > 0) {
            var indx = selRows[0];
            var selIndx = $("#grid").bootgrid("getCurrentRows").propValues("ticketId").indexOf(indx);
            var cmpy = $("#grid").bootgrid("getCurrentRows")[selIndx];
            console.log(cmpy);
            
            $( "#dlgTicket").find("#cTitle").removeAttr("disabled");
            $( "#dlgTicket").find("#cDesc").removeAttr("disabled");
            $( "#dlgTicket").find("#cStatus").removeAttr("disabled");
            $( "#dlgTicket").find("#cUser").attr("disabled", true);
            
            $( "#dlgTicket").find("#action").val("edit");
            $( "#dlgTicket").find("#cId").val(cmpy.ticketId);
            $( "#dlgTicket").find("#cUser").val(cmpy.user_userId);
            $( "#dlgTicket").find("#cTitle").val(cmpy.ticketTitle);
            $( "#dlgTicket").find("#cDesc").val(cmpy.ticketDesc);
            $( "#dlgTicket").find("#cStatus").val(cmpy.ticketStatus);
            $( "#dlgTicket").find("#msg").html("");
        }
        
        dlgEditTicket = $( "#dlgTicket" ).dialog({
            title: "Edit Ticket",
            autoOpen: false, 
            modal: true,
            buttons: {
                Edit: function() {
                    $( "#dlgTicket").find("#cUser").removeAttr("disabled");
                    $("#frmTicket").submit();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            height: 450,
            width: 400
        });
        dlgEditTicket.dialog( "open" );
    });
    
    $("#del").on("click", function () {
        var selRows = $("#grid").bootgrid("getSelectedRows");
        if(selRows.length > 0) {
            var indx = selRows[0];
            var selIndx = $("#grid").bootgrid("getCurrentRows").propValues("ticketId").indexOf(indx);
            var cmpy = $("#grid").bootgrid("getCurrentRows")[selIndx];
            
            $( "#dlgTicket").find("#cTitle").attr("disabled", true);
            $( "#dlgTicket").find("#cDesc").attr("disabled", true);
            $( "#dlgTicket").find("#cStatus").attr("disabled", true);
            $( "#dlgTicket").find("#cUser").attr("disabled", true);
            
            $( "#dlgTicket").find("#action").val("delete");
            $( "#dlgTicket").find("#cId").val(cmpy.ticketId);
            $( "#dlgTicket").find("#cUser").val(cmpy.user_userId);
            $( "#dlgTicket").find("#cTitle").val(cmpy.ticketTitle);
            $( "#dlgTicket").find("#cDesc").val(cmpy.ticketDesc);
            $( "#dlgTicket").find("#cStatus").val(cmpy.ticketStatus);
            $( "#dlgTicket").find("#msg").html("Are you sure, you want to delete ticket?");
        }
        
        dlgDelTicket = $( "#dlgTicket" ).dialog({
            title: "Delete Ticket",
            autoOpen: false, 
            modal: true,
            buttons: {
                Confirm: function() {
                    $( "#dlgTicket").find("#cUser").removeAttr("disabled");
                    $("#frmTicket").submit();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            height: 480,
            width: 400
        });
        dlgDelTicket.dialog( "open" );
    });
});
</script>
@stop
