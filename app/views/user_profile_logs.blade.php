@extends('user_profile')

@section('jumbo_section')

@stop

@section('user_content')
            <h2 class="sub-header">Logs</h2>
            <div class="table-responsive">
                <table id="grid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="false" data-row-select="true" data-keep-selection="true" style="font-size: 9pt">
                    <thead>
                        <tr>
                            <th data-column-id="eventLogId" data-identifier="true" data-type="numeric" data-align="right" data-width="5%">ID</th>
                            <th data-column-id="eventLogTitle" data-order="asc" data-align="center" data-header-align="center" data-width="20%" searchable="true">Title</th>
                            <th data-column-id="eventLogDetails" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="60%">Description</th>
                            <th data-column-id="eventLogDate" data-formatter="link" data-sortable="false" data-width="15%">Date</th>
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
        url: "/api/admin/eventlogs?type=user",
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
        responseHandler: function(rs) {
            $.each(rs.rows, function(indx, val) {
                if(val.eventLogDetails.indexOf("{") > -1) {
                    var jsonObj = JSON.parse(val.eventLogDetails);
                    console.log(jsonObj);
                    val.eventLogDetails = "";
                    var items = [];
                    $.each(jsonObj, function(key, val) {
                        items.push(val);
                    });
                    val.eventLogDetails = items.join();
                }
            });
            
            return rs;
        },
        selection: true,
        multiSelect: false
    });
});
</script>
@stop
