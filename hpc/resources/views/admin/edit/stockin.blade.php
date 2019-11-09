@extends('admin.master')

@section('admin_content')
    <style>
        .card-header{
            padding: 10px 10px 10px 10px;
        }
    </style>
    <div class="row stockin">
        <div class="col card l10 m10 s10">
            <form action="/stockin/update" method="post">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{$stockin->id}}">
                <div class="cyan darken-2 center-align card-header white-text">
                    <h5>Edit Stockin</h5>
                </div>
                <div class="card-content">
                    <div class="row">
                        <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                            <input type="text" class="datepicker" id="date" name="date" value="{{$stockin->date}}">
                            <label for="date">
                                Date :
                            </label>
                        </div>
                        <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                            <input type="text" id="vehicleno" name="vehicleno" value="{{$stockin->vehicleno}}">
                            <label for="vehicleno" >
                                Vehicle Number :
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                            <input type="text" id="gatepass" name="gatepass" value="{{$stockin->gatepass}}">
                            <label for="gatepass">
                                Gate Pass:
                            </label>
                        </div>
                        <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                            <input type="text" id="drivername" name="drivername" value="{{$stockin->drivername}}">
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
                            <a href="/stockin" class="btn white teal-text"> Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(function(){
            (".stockin form").submit(function(ev){
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
        });
    </script>
@endsection