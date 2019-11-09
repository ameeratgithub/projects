@extends('admin.master')

@section('admin_content')
    <style>
        .saledetails .card-header{
            padding: 10px 10px 10px 10px;
        }
        .invoiceinfo{
            font-size: large;
        }
        .invoiceinfo span:first-child{
            margin-left: 10%;
        }
        .invoiceinfo span:last-child{
            margin-right: 10%;
        }
        small.right{
            margin-right: 10%;
        }
    </style>
    @if(!empty($invoice))
        <div class="card">
            <div class="card-content cyan lighten-5 teal-text invoiceinfo">
                <span>Invoice: {{$invoice->id}}</span>
                <span class="right">Date : {{$invoice->created_at}}</span>
            </div>
        </div>
        <div class="row saledetails">
            <div class="col l12 m12 s12">
                <div class="card">
                    <div class="cyan darken-2 card-image white-text center card-header">
                        <h5>Details <small class="right">Total Amount : {{$invoice->totalamount}}</small></h5>

                    </div>
                    <div class="card-content">
                        @if(!empty($invoice->saleDetails))
                            <table class="centered highlight">
                                <thead>
                                <tr>
                                    <th>Product Code</th>
                                    <th>Product Description</th>
                                    <th>Quantity</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($invoice->saleDetails as $saleDetail)
                                    <tr>
                                        <td>{{$saleDetail->productcode}}</td>
                                        <td>{{\App\am_product::where('code',$saleDetail->productcode)->first()->description}}</td>
                                        <td>{{$saleDetail->quantity}}</td>
                                        <td>{{$saleDetail->rate}}</td>
                                        <td>{{$saleDetail->total}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <h5>No Detail found</h5>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        @else
                            <h5>No  Detail found</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-content center-align cyan lighten-5 teal-text invoiceinfo">
                No Record Found
            </div>
        </div>
    @endif

@endsection