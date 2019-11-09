@extends('admin.master')

@section('admin_content')
    <style>
        .payments .card-header{
            padding: 10px 10px 10px 10px;
        }
        #modalAddPayment{
            overflow-y: scroll;
        }
        #modalDeletePayment{
            margin-top: 10%;
        }
        #a_printpayments{
            right: 68px;
        }
        .autocomplete {
            display: -ms-flexbox;
            display: flex;
        }
        .autocomplete .ac-dropdown .ac-hover {
            background: #eee;
        }
        .autocomplete .ac-input {
            -ms-flex: 1;
            flex: 1;
            min-width: 150px;
            padding-top: 0.6rem;
        }
        .autocomplete .ac-input input {
            height: 2.4rem;
        }

    </style>
    <input type="hidden" id="customers" value="{{$customers}}">
    <div id="modalAddPayment" class="modal">
        <form action="/payment/add" method="post">
            {{csrf_field()}}
            <div class="modal-content">
                <h4>Add Payment: </h4>
                <div class="row">
                    <div class="input-field  col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <div class="autocomplete" id="customer_autocomplete">
                            <div class="ac-input">
                                <input type="text" id="customer" name="customer" data-activates="singledropdown" data-beloworigin="true" autocomplete="off">
                                <label for="customer">
                                    Customer Phone:
                                </label>
                                <input type="hidden" name="customerid" id="customerid">
                            </div>
                            <ul id="singledropdown" class="dropdown-content ac-dropdown"></ul>
                        </div>
                    </div>
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="customername" disabled>
                        <label for="customername">
                            Customer Name:
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="amount" name="amount">
                        <label for="amount">
                            Amount :
                        </label>
                    </div>
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <select id="type" name="type">
                            <option value="" selected disabled>Choose Payment Type</option>
                            <option value="paid">Paid</option>
                            <option value="purchased">Purchased</option>
                        </select>
                        <label for="type">
                            Payment Type:
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="method" value="cash" name="method">
                        <label for="method">
                            Payment Method :
                        </label>
+
                    </div>
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <select id="resource" name="resource" disabled>
                            <option value="" selected disabled>Choose Resource : </option>
                            <option value="UBL">UBL</option>
                            <option value="HBL">HBL</option>
                            <option value="ABL">ABL</option>
                            <option value="ALF">ALF</option>
                            <option value="FSL">FSL</option>
                            <option value="ASK">ASK</option>
                            <option value="AL_HB">AL_HB</option>
                        </select>
                        <label for="resource">
                            Resource:
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4">
                        <button type="submit" class="btn green"> Save </button>
                    </div>
                    <div class="col l2 m2 s2 ">
                        <button type="button" class="modal-action modal-close btn white teal-text" onclick="return false;"> Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="modalDeletePayment" class="modal">
        <form action="/payment/delete" method="post">
            {{csrf_field()}}
            <input type="hidden" class="entityid" name="id"/>
            <div class="modal-content center">
                <h5>Are you sure to delete payment? </h5>
                <br/><br/>
                <div class="row">
                    <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4" style="width: 19%">
                        <button type="submit" class="btn red darken-2">Remove</button>
                    </div>
                    <div class="col l2 m2 s2">
                        <button class="btn modal-action modal-close white teal-text" onclick="return false;"> Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row payments">
        <div class="col l12 m12 s12">
            <div class="card">
                <div class="cyan darken-2 card-image white-text center card-header">
                    <h5>Payments</h5>
                    <a id="a_printpayments" href="javascript:void(0)" class="pdfexport btn-floating red darken-3 halfway-fab tooltipped" data-tooltip="Close"><i class="material-icons">file_download</i></a>
                    <a href="#modalAddPayment" class="btn-floating green halfway-fab tooltipped" data-tooltip="Add Payment"><i class="material-icons ">add</i></a>
                </div>
                <div class="card-content">

                        <table class="centered highlight">
                            <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                                <th>Date</th>
                                <th>Resource</th>
                                <th>Method</th>
                                <th>Paid</th>
                                <th>Purchased</th>
                                <th>Remaining</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                            $payments=[];
                            @endphp
                            @if(!empty($customers))
                            @foreach($customers as $customer)
                                @if($customer->payments->last())
                                    @php
                                    $payment=$customer->payments->last();
                                    $payment["customername"]=$customer->name;
                                    $payment["customerphone"]=$customer->phone;
                                    array_push($payments,$payment);
                                    @endphp
                                    <tr>
                                        <td>{{$customer->name}}</td>
                                        <td>{{$customer->phone}}</td>
                                        <td>{{$payment->created_at}}</td>
                                        <td>{{$payment->resource}}</td>
                                        <td>{{$payment->method}}</td>
                                        <td>{{$payment->paid}}</td>
                                        <td>{{$payment->purchased}}</td>
                                        <td>{{$payment->remained}}</td>
                                        <td>
                                            <a href="#modalDeletePayment"  data-entityid="{{$payment->id}}" data-linkaction="delete" class="tooltipped" data-tooltip="Delete"><i class="material-icons red-text">delete_forever</i></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @else
                                <td><h5>No Payment Found</h5></td>
                            @endif
                            <input type="hidden" id="lastpayments" value="{{json_encode($payments)}}">
                            </tbody>
                        </table>
                    {{--@if(!empty($customers))
                    @foreach($customers as $customer)
                            @if(!empty($customer->payments))

                                @php
                                $entities=$payments;
                                @endphp
                                @include('admin.components.paginator')
                        @endforeach
                    @endif--}}
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('materializecss/js/jquery.materialize-autocomplete.js')}}"></script>
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
            $(body).append('<h5 class="center-align">{{\App\am_self::first()->name}}</h5>').css({
                paddingTop:'50px'
            });
            $(body).append(div);
        }
        function getTableHead(){
            var tableHead=$('<thead/>');
            tableHead.append(getTableRow('<th/>',['Customer Name','Phone','Date','Resource','Method','Paid','Purchased','Remaining']));
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
                            payment.customername,payment.customerphone,
                            payment.created_at,payment.resource,
                            payment.method,payment.paid,payment.purchased,payment.remained
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
                newwindow.payments=$("#lastpayments").val();
                var link=$('<link/>').attr('href','{{asset('materializecss/css/materialize.min.css')}}').attr('rel','stylesheet');
                $(newwindow.document.head).append(link);
                previewCustomerDetails(newwindow);
            });


            $("#modalAddPayment form").submit(function(ev){
                var customerid=$("#customerid").val();
                var amount=$("#amount").val();
                var type=$("#type").val();

                if(!customerid|| !customerid.trim()){
                    Materialize.toast('Please choose customer',4000,'red');
                    ev.preventDefault();
                    return false;
                }
                if(!amount|| !amount.trim() || isNaN(amount)){
                    Materialize.toast('Please enter valid amount',4000,'red');
                    ev.preventDefault();
                    return false;
                }
                if(!type|| !type.trim()){
                    Materialize.toast('Please choose payment type',4000,'red');
                    ev.preventDefault();
                    return false;
                }
                if(type==="paid"){
                    var method=$("#method").val();
                    if(!method|| !method.trim()){
                        Materialize.toast('Please choose payment method',4000,'red');
                        ev.preventDefault();
                        return false;
                    }
                }
            });
            $("#type").change(function(ev){
                var type=$(this).val();
                if(type=="paid"){
                    /*$("#method").prop('disabled',false).material_select();*/
                    $("#resource").prop('disabled',false).material_select();
                }
                else {
                    /*$("#method").prop('disabled',true);*/
                    $("#resource").prop('disabled',true).material_select();
                }
            });
            var customer=$("#customer");
            var autocomplete=customer.materialize_autocomplete({
                limit:4,
                multiple:{
                    enable:false
                },
                dropdown:{
                    el:"#singledropdown"
                },
                getData:function(value,callback){
                    initializeAutoComplete(value)
                },
                onSelect:function (item) {
                    $("#customerid").val(item.id);
                    getCustomerName(item.text);
                }

            });
            function getCustomerName(phone){
                var customers=JSON.parse($("#customers").val());
                $.each(customers,function(idx,customer){
                    if(customer.phone==phone){
                        $("#customername").val(customer.name).css('color','black');
                        $("label[for='customername']").addClass('active');

                        console.log(customer.name);
                        return false;
                    }
                    else console.log(phone);
                });

            }
            function initializeAutoComplete(input){
                var customers=JSON.parse($("#customers").val());
                var resultCache={};
                resultCache[input.toUpperCase().trim()]=[];
                $.each(customers,function(index,customer){
                    if(customer.phone.lastIndexOf(input)>-1){
                        resultCache[input.trim()].push({
                            id:customer.id,
                            text:customer.phone,
                        });
                    }
                });
                customer.materialize_autocomplete("option").resultCache=resultCache;
                customer.trigger('input');
            }
            $("#modalDeletePayment form").submit(checkEid);
            function checkEid(ev){
                var companyid=$(this).find('.entityid').val();
                if(!companyid)
                {
                    Materialize.toast('Error while deleting record...!',3000,'red');
                    ev.preventDefault();
                }
            }
        });
    </script>
@endsection