@extends('admin.master')

@section('admin_content')
    <style>
        .biltihistory .card-header{
            padding: 10px 10px 10px 10px;
        }
        #modalDeleteBiltiRecord{
            margin-top: 10%;
        }
    </style>
    <div id="modalAddBiltiRecord" class="modal">
        <form action="/biltihistory/add" method="post">
            {{csrf_field()}}
            <div class="modal-content">
                <h4>Add Bilti Record: </h4>
                <div class="row">
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="number" name="number">
                        <label for="number">
                            Bilti Number :
                        </label>
                    </div>
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="adda" name="adda">
                        <label for="adda">
                            Adda :
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                        <input type="text" id="invoiceid" name="invoiceid">
                        <label for="invoiceid">
                            Invoice :
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
    <div id="modalDeleteBiltiRecord" class="modal">
        <form action="/biltihistory/delete" method="post">
            {{csrf_field()}}
            <input type="hidden" class="entityid" name="number"/>
            <div class="modal-content center">
                <h5>Are you sure to delete bilti record? </h5>
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
    <div class="row biltihistory">
        <div class="col l10 m10 s10">
            <div class="card">
                <div class="cyan darken-2 card-image white-text center card-header">
                    <h5>Bilti History</h5>
                    <a href="#modalAddBiltiRecord" class="btn-floating green  halfway-fab"><i class="material-icons">add</i></a>
                </div>
                <div class="card-content">
                    @if(!empty($biltihistory))
                        <table class="centered highlight">
                            <thead>
                            <tr>
                                <th>Number</th>
                                <th>Adda</th>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($biltihistory as $item)
                                <tr>
                                    <td>{{$item->number}}</td>
                                    <td>{{$item->adda}}</td>
                                    <td>{{$item->invoiceid}}</td>
                                    <td>{{$item->sale->oncredit->customer->name}}</td>
                                    <td>
                                        <a href="/biltihistory/edit/{{$item->number}}"><i class="material-icons">edit</i></a>
                                        <a href="/sale/{{$item->invoiceid}}/details"><i class="material-icons green-text">open_in_new</i></a>
                                        <a href="#modalDeleteBiltiRecord" data-entityid="{{$item->number}}" data-linkaction="delete"><i class="material-icons red-text">delete_forever</i></a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <h5 align="center">No history found</h5>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        @php
                        $entities=$biltihistory;
                        @endphp
                        @include('admin.components.paginator')
                    @else
                        <h5>No history found...!</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $("#modalAddBiltiRecord form").submit(function (ev) {
                var number=$("#number").val();
                var adda=$("#adda").val();
                var invoiceid=$("#invoiceid").val();
                if(!number || !number.trim()){
                    Materialize.toast('Please enter valid number...!',3000,'red');
                    ev.preventDefault();
                    return false;
                }
                else if(!adda || !adda.trim()){
                    Materialize.toast('Please enter valid adda...!',3000,'red');
                    ev.preventDefault();
                    return false;
                }
                else if(!invoiceid|| !invoiceid.trim() || isNaN(invoiceid)){
                    Materialize.toast('Please enter valid invoice...!',3000,'red');
                    ev.preventDefault();
                    return false;
                }
            });
            $("#modalDeleteBiltiRecord form").submit(checkid);
            function checkid(ev){

                var id=$(this).find('.entityid').val();
                if(!id)
                {
                    Materialize.toast('Error while deleting record...!',3000,'red');
                    ev.preventDefault();
                }
            }
        });
    </script>
@endsection