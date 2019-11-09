@php
$self=\App\am_self::find(1);
@endphp
<h4 class="center-align">{{$self->name}}</h4>
<br/>
<div class="row"><div class="col l5 m5 s5"><b>Date Time : </b>{{$printData->created_at}}</div></div>
<div class="row">
    <div class="col l5 m5 s5 "><b>{{$copytype}}</b></div>
    <div class="col l5 m5 s5 right-align offset-l1 offset-m1 offset-s1 "><b>Cashier : </b>{{\Illuminate\Support\Facades\Auth::user()->name}}</div>
</div>
<div class="row">
    <div class="col l5 m5 s5 "><b>Bill Type : </b>{{$printData->billtype}}</div>
    <div class="col l5 m5 s5 right-align offset-l1 offset-m1 offset-s1"><b>Invoice : </b>{{$printData->id}}</div>
</div>
<table>
    <thead>
    <th>Product</th>
    <th>Description</th>
    <th>Quantity</th>
    <th>Packet</th>
    <th>Rate</th>
    <th>Total</th>
    </thead>
    <tbody>
    @forelse($printData->saleDetails as $saleDetail)
        @php
        $product=\App\am_product::where('code',$saleDetail->productcode)->first();
        @endphp
    <tr>
        <td>{{$saleDetail->productcode}}</td>
        <td>{{$product->description}}</td>
        <td>{{$saleDetail->quantity}}</td>
        <td>{{$product->quantity." ".$product->type}}</td>
        <td>{{$saleDetail->rate}}</td>
        <td>{{$saleDetail->total}}</td>
    </tr>
    @empty
        <tr>
            <td colspan="4">No Data Found</td>
        </tr>
    @endforelse

    </tbody>
</table>
<br/><br/>
<div class="row">
    <div class="col l5 m5 s5">
        @if($printData->billtype=="On Credit")
            <div class="row"><div class="col l12 m12 s12"><b>Paid : </b>{{$printData->paid}}</div></div>
            <div class="row"><div class="col l12 m12 s12"><b>Remaining : </b>{{$printData->remaining}}</div></div>
            <div class="row"><div class="col l12 m12 s12"><b>Previous Remaining : </b>{{$printData->lastremaining}}</div></div>
        @endif
        <div class="row"><div class="col l12 m12 s12"><b>Total Remaining : </b>{{$printData->totalremaining}}</div></div>
    </div>
    <div class="col l5 m5 s5 right-align offset-l1 offset-m1 offset-s1">
        <div class="row"><div class="col l12 m12 s12"><b>Total Bill : </b>{{$printData->totalamount}}</div></div>
        <div class="row"><div class="col l12 m12 s12">{{$printData->customername}}</div></div>
        <div class="row"><div class="col l12 m12 s12">{{$printData->customerphone}}</div></div>
        <br/>
    </div>
    <div class="row center-align"><div class="col l12 m12 s12"><b>Signature : </b>___________________</div></div>
</div>
