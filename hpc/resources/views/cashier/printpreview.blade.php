<html>
<head>
    <link href="{{asset('materializecss/css/materialize.min.css')}}" rel="stylesheet"/>
    <style>
        body{
            padding: 20px 50px 0 50px;
        }
        .page-break{
            page-break-after: always;
        }
        /*@media all{
            .page-break{display: none}
        }
        @media print{
            .page-break{display: none;page-break-before: always}
        }*/
    </style>
</head>
<body>
@php
$printData=Session::get('printData');
@endphp
@if($printData->billtype=="On Credit" || ($printData->billType=="On Cash" && $printData->totalremaining >0))
    @php
    $copytype='Company Copy';
    @endphp
    @include('cashier.components.saleprint')
    <div class="page-break"></div>
@endif
@php
$copytype='Customer Copy';
@endphp
@include('cashier.components.saleprint')
<div class="page-break"></div>
</body>
</html>