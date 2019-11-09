@extends('cashier.master')

@section('cashier_content')
    <style>
        .paymentmethod{
            padding-bottom: 15px;
        }
        .paymentmethod .col h5{
            margin-top: 11%;
        }

    </style>
    <div class="row">
        <div class="col l3 m3 s3">
            @include('cashier.components.customerfilter')
        </div>
        <div class="col l9 m9 s9">
            @include('cashier.components.customerdetails')
        </div>
    </div>
    <script>
        $(function(){
           $('input.with-gap').click(function(ev){
               var method=$(this).attr('id');
               if(method=="cash"){
                   disableCustomers();
               }
               else displayAllCustomers();
           });
        });
    </script>
@endsection
