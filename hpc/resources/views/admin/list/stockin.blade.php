@extends('admin.master')

@section('admin_content')
    <style>
        .stockin .card-header{
            padding: 10px 10px 10px 10px;
        }
        .datepicker{
            z-index: 500;
        }
        #modalDeleteStockin{
            margin-top: 10%;
        }
    </style>
    <div id="modalAddStockin" class="modal">
        <form action="/stockin/add" method="post">
            {{csrf_field()}}
            <div class="modal-content">
                <h4>Add Stockin: </h4>
                <div class="row">
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" class="datepicker" id="date" name="date">
                        <label for="date">
                            Date :
                        </label>
                    </div>
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="vehicleno" name="vehicleno">
                        <label for="vehicleno" >
                            Vehicle Number :
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="gatepass" name="gatepass">
                        <label for="gatepass">
                            Gate Pass:
                        </label>
                    </div>
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="drivername" name="drivername">
                        <label for="drivername" >
                            Driver Name :
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
    <div id="modalDeleteStockin" class="modal">
        <form action="/stockin/delete" method="post">
            {{csrf_field()}}
            <input type="hidden" class="entityid" name="id"/>
            <div class="modal-content center">
                <h5>Are you sure to delete stockin? </h5>
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
    <div class="row stockin">
        <div class="col l10 m10 s10">
            <div class="card">
                <div class="cyan darken-2 card-image white-text center card-header">
                    <h5>Stockin</h5>
                    <a href="#modalAddStockin" class="btn-floating green halfway-fab"><i class="material-icons ">add</i></a>
                </div>
                <div class="card-content">
                    @if(!empty($stockin))
                        <table class="centered highlight">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Vehicle No</th>
                                <th>Gate Pass</th>
                                <th>Driver Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($stockin as $item)
                                <tr>
                                    <td>{{$item->date}}</td>
                                    <td>{{$item->vehicleno}}</td>
                                    <td>{{$item->gatepass}}</td>
                                    <td>{{$item->drivername}}</td>
                                    <td>
                                        <a href="/stockin/edit/{{$item->id}}"><i class="material-icons">edit</i></a>
                                        <a href="/stockin/details/{{$item->id}}"><i class="material-icons">open_in_new</i></a>
                                        <a href="#modalDeleteStockin" data-entityid="{{$item->id}}" data-linkaction="delete"><i class="material-icons red-text">delete_forever</i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <h5 align="center">No stockin found</h5>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        @php
                        $entities=$stockin;
                        @endphp
                        @include('admin.components.paginator')
                    @else
                        <h5>No stockin found</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){

            $("#modalAddStockin form").submit(function(ev){
                var date=$("#date").val();
                var vehicleno=$("#vehicleno").val();
                var gatepass=$("#gatepass").val();
                var drivername=$("#drivername").val();
                if(!date || !date.trim()){
                    Materialize.toast('Please enter valid date',3000,'red');
                    ev.preventDefault();
                    return;
                }
                else if(!vehicleno|| !vehicleno.trim()){
                    Materialize.toast('Please enter valid vehicle no',3000,'red');
                    ev.preventDefault();
                    return;
                }
                else if(!gatepass|| !gatepass.trim()){
                    Materialize.toast('Please enter valid gatepass',3000,'red');
                    ev.preventDefault();
                    return;
                }
                else if(!drivername|| !drivername.trim()){
                    Materialize.toast('Please enter valid driver name',3000,'red');
                    ev.preventDefault();
                    return;
                }
            });
            $("#modalDeleteStockin form").submit(checkEid);
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
