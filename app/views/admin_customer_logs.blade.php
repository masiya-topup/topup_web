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

@stop

@section('admin_content')
            <h2 class="sub-header">Logs</h2>
            <div class="table-responsive">
                <table id="grid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="false" data-row-select="true" data-keep-selection="true" style="font-size: 9pt">
                    <thead>
                        <tr>
                            <th data-column-id="eventLogId" data-identifier="true" data-type="numeric" data-align="right" data-width="5%">ID</th>
                            <th data-column-id="eventLogTitle" data-order="asc" data-align="center" data-header-align="center" data-width="20%" searchable="true">Title</th>
                            <th data-column-id="eventLogDetails" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="60%">Description</th>
                            <th data-column-id="eventLogDate" data-formatter="link" data-sortable="false" data-width="15%">Open Date</th>
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
        url: "/api/admin/eventlogs?type=customercare",
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
    });
});
</script>
@stop
