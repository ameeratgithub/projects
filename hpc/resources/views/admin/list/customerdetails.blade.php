@extends('admin.master')

@section('admin_content')
    <style>
        .customerdetails .card-header{
            padding: 10px 10px 10px 10px;
        }
        .customerinfo span{
            font-size: large;
        }
        .customerinfo span:first-child{
            margin-left: 10%;
        }
        .customerinfo span:last-child{
            margin-right: 10%;
        }
    </style>
    <input type="hidden" id="paymentsPrint" value="{{$customer->payments}}">
    <div class="modal" id="modalExportConfirmation">
        <div class="modal-content">
            <h5>Customer Details will be cleared. Do you want to export it to pdf?</h5>
            <div class="row">
                <div class="col l3 m3 s3 offset-l4 offset-m4 offset-s4">
                    <form>
                        <button type="button"  class="pdfexport clearDetails btn green modal-action modal-close" onclick="return false;"> Export </button>
                    </form>
                </div>
                <div class="col l2 m2 s2 ">
                    <form id="clearDetails" action="/customer/{{$customer->id}}/clearDetails" method="post">
                        {{csrf_field()}}
                        <button type="submit" class="btn white teal-text"> No</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-content cyan lighten-5 teal-text customerinfo">
            <span>Name: {{$customer->name}}</span>
            <span class="right">Phone: {{$customer->phone}}</span>
        </div>
    </div>
    <div class="row customerdetails">
        <div class="col l12 m12 s12">
            <div class="card">
                <div class="cyan darken-2 card-image white-text center card-header">
                    <h5>Details</h5>
                    <a href="javascript:void(0)" class="pdfexport btn-floating green halfway-fab tooltipped" data-tooltip="Download Details"><i class="material-icons">file_download</i></a>
                </div>
                <div class="card-content">
                    @if(!empty($customer->payments))
                        <table class="centered highlight">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Resource</th>
                                <th>Paid</th>
                                <th>Method</th>
                                <th>Purchased</th>
                                <th>Remaining</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($customer->payments as $payment)
                                <tr>
                                    <td>{{$payment->created_at}}</td>
                                    <td>{{$payment->resource}}</td>
                                    <td>{{$payment->paid}}</td>
                                    <td>{{$payment->method}}</td>
                                    <td>{{$payment->purchased}}</td>
                                    <td>{{$payment->remained}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <h5>No Payment found</h5>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    @else
                        <h5>No Payment found</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewCustomerDetails(window){
            var table=$('<table/>').addClass('centered');
            var body=window.document.body;
            var div=$('<div/>').addClass('row card');
            var divCol=$("<div/>").addClass('card-content col l8 m8 s8 offset-l2 offset-m2 offset-s2');
            $(table).append(getTableHead());
            $(table).append(getTableBody(JSON.parse(window.payments)));
            divCol.append(table);
            div.append(divCol);
            var divWhoName=$('<div/>').addClass('col l4 m4 s4 offset-l2 offset-m2 offset-s2').text("{{$customer->name}}");
            var divWhoPhone=$('<div/>').addClass('col l3 m3 s3 offset-l1 offset-m1 offset-s1 right-align').text("{{$customer->phone}}");
            var divWho=$("<div/>").addClass('row').css({
                fontWeight:'bold'
            }).append(divWhoName).append(divWhoPhone);
            $(body).append('<h5 class="center-align">{{\App\am_self::first()->name}}</h5>');
            $(body).append(divWho).css({
                paddingTop:'50px'
            });
            $(body).append(div);

        }
        function getTableHead(){
            var tableHead=$('<thead/>');
            tableHead.append(getTableRow('<th/>',['Date','Resource','Paid','Method','Purchased','Remaining']));
            return tableHead;
        }
        function getTableBody(payments){
            var tableBody=$('<tbody/>');
            if(payments.length<=0){
               tableBody.append(getTableRow('<td colspan="8"></td>',['No Record Found']));
            }
            $.each(payments,function(index,payment){
               tableBody.append(getTableRow('<td/>',
                       [
                           payment.created_at,payment.resource,
                           payment.paid,payment.method,
                           payment.purchased,payment.remained
                       ]));
            });
            return tableBody;
        }
        function getTableRow(tag,array){
            var tr=$('<tr/>');
            $.each(array,function(index,item){
                $(tag).text(item).appendTo(tr);
            });
            return tr;
        }
        $(function(){
            $('.pdfexport').click(function(){
                var newwindow=window.open("",'_blank');
                newwindow.payments=$("#paymentsPrint").val();
                var link=$('<link/>').attr('href','{{asset('materializecss/css/materialize.min.css')}}').attr('rel','stylesheet');
                $(newwindow.document.head).append(link);
                previewCustomerDetails(newwindow);
                if($(this).hasClass('clearDetails'))
                $("#clearDetails").submit();
            });
        });
    </script>
@endsection
@section('page_script')
<script>
    $(function(){
        @if(\Illuminate\Support\Facades\Session::has('exportconfirmation'))
                $("#modalExportConfirmation").modal('open');
        @endif
    });
</script>
@endsection