@extends('layout.master')

@section('css_head_section')
{{ HTML::style('css/_lib/bootgrid/jquery.bootgrid.css') }}  
@stop

@section('js_head_section')
{{ HTML::script('js/_lib/bootgrid/jquery.bootgrid.js') }}
{{ HTML::script('js/_lib/bootgrid/jquery.bootgrid.fa.js') }}
{{ HTML::script('js/_lib/validate/jquery.validate.js') }}
@stop

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

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 main">
            <h2 class="sub-header">Transactions</h2>
            <div class="table-responsive">
                <form class="form-inline" role="form">
                    <div class="form-group">
                      <label for="from">From:</label>
                      <input type="text" class="form-control input-sm" id="from" name="from">
                    </div>
                    <div class="form-group">
                      <label for="to">to:</label>
                      <input type="text" class="form-control input-sm" id="to" name="to">
                    </div>
                    <button type="button" class="btn btn-default btn-sm" id="lookUp">LookUp</button>
                </form>
                <table id="grid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="false" data-row-select="true" data-keep-selection="true" style="font-size: 9pt">
                    <thead>
                        <tr>
                            <th data-column-id="transactionId" data-type="numeric" data-align="right" data-width="3%">ID</th>
                            <th data-column-id="transactionPaymentId" data-order="asc" data-align="center" data-header-align="center" data-width="8%" searchable="true">PaymentId</th>
                            <th data-column-id="transactionRefId" data-order="asc" data-align="center" data-header-align="center" data-width="8%">RefId</th>
                            <th data-column-id="company_companyName" data-order="asc" data-align="center" data-header-align="center" data-width="8%">Company</th>
                            <th data-column-id="category_categoryName" data-order="asc" data-align="center" data-header-align="center" data-width="8%">Category</th>
                            <th data-column-id="service_serviceName" data-order="asc" data-align="center" data-header-align="center" data-width="8%">Service</th>
                            <th data-column-id="user_userLogin" data-order="asc" data-align="center" data-header-align="center" data-width="8%">Username</th>
                            <th data-column-id="user_userEmail" data-order="asc" data-align="center" data-header-align="center" data-width="8%">DoneBy</th>
                            <th data-column-id="phone_userPhoneNo" data-order="asc" data-align="center" data-header-align="center" data-width="8%">PhoneNo</th>
                            <th data-column-id="transactionAmount" data-order="asc" data-align="center" data-header-align="center" data-width="8%">Amount</th>
                            <th data-column-id="transactionType" data-order="asc" data-align="center" data-header-align="center" data-width="8%">Type</th>
                            <th data-column-id="transactionSystem" data-order="asc" data-align="center" data-header-align="center" data-width="8%">System</th>
                            <th data-column-id="transactionDate" data-order="asc" data-align="center" data-header-align="center" data-width="8%">Date</th>
                            <th data-column-id="transactionStatus" data-order="asc" data-align="center" data-header-align="center" data-width="8%">Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop

@section('js_body_section')
<script lang="javascript">
$().ready(function() {
    $( "#from" ).datepicker({
      defaultDate: "-1w",
      dateFormat: 'yy-mm-dd',
      maxDate: "0",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      dateFormat: 'yy-mm-dd',
      maxDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
    $('#from').datepicker("setDate", "-1w" );
    $('#to').datepicker("setDate", "+1d" );
    
    $("#grid").bootgrid({
        ajax: true,
        url: "/api/admin/transactions",
        ajaxSettings: {
            method: "GET",
            cache: false
        },
        searchSettings: {
            delay: 250,
            characters: 3
        },
        requestHandler: function (request) {
            request.startDate = $('#from').val();
            request.endDate = $('#to').val();
            if(request.searchPhrase) {
                request.search = request.searchPhrase;
            }
            return request;
        },
        selection: true,
        multiSelect: false
    });
    
    $( "#lookUp" ).on("click", function(){
        $("#grid").bootgrid("reload");
    });
});

</script>
@stop
