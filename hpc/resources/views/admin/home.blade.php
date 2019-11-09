@extends('admin.master')

@section('admin_content')
    <style>

        #fm_searchinvoice .btn{
            margin-top: 25%;
        }
        .reorderableproducts .card-content{
            overflow-y: auto;max-height: 420px;
        }
    </style>
    <div class="row">
        <form action="/sale/search" id="fm_searchinvoice" method="post">
            {{csrf_field()}}
            <div class="input-field col l7 m7 s7 offset-l1 offset-m1 offset-s1">
                <input type="text" id="invoiceid" name="invoiceid">
                <label for="invoiceid">
                    Search Invoice:
                </label>
            </div>
            <div class="col l1 m1 s1">
                <button type="submit" class="btn"><i class="material-icons">search</i></button>
            </div>
        </form>
    </div>
    <div class="row reorderableproducts">
        <div class="col l10 m10 s10">
            <div class="card">
                <div class="card-content">
                        <table class="centered highlight">
                            <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Description</th>
                                <th>Stock</th>
                                <th>Reorder Rate</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($reorderableproducts as $item)
                                <tr>
                                    <td>{{$item->code}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->stock}}</td>
                                    <td>{{$item->reorderrate}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <h5 align="center">No Product found</h5>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('page_script')
    <script>
        $(function(){
            var todayDate=(new Date).toLocaleDateString();
            $("#date").val(todayDate).siblings('label').addClass('active');
            $("#date").change(function(ev){
                console.log($(this).val());
            });
            $("#fm_searchinvoice").submit(function (ev) {
                var invoice=$("#invoiceid").val();
                if(!invoice || !invoice.trim() || isNaN(invoice)){
                    Materialize.toast('Please enter valid invoice',3000,'red');
                    ev.preventDefault();
                }
            });
        });
    </script>
    @endsection