@extends('admin.master')

@section('admin_content')
    <style>
        .card-header{
            padding: 10px 10px 10px 10px;
        }
    </style>
    <div class="row biltihistory">
        <div class="col card l10 m10 s10">
            <form action="/biltihistory/update" method="post">
                {{csrf_field()}}
                <input type="hidden" name="oldnumber" value="{{$biltihistory->number}}">
                <div class="cyan darken-2 center-align card-header white-text">
                    <h5>Edit Bilti Record</h5>
                </div>
                <div class="card-content">
                    <div class="row">
                        <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                            <input type="text" id="newnumber" name="newnumber" value="{{$biltihistory->number}}">
                            <label for="newnumber">
                                Bilti Number :
                            </label>
                        </div>
                        <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                            <input type="text" id="adda" name="adda" value="{{$biltihistory->adda}}">
                            <label for="adda">
                                Adda :
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                            <input type="text" id="invoiceid" name="invoiceid" value="{{$biltihistory->invoiceid}}">
                            <label for="invoiceid">
                                Invoice :
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4">
                            <button type="submit" class="btn blue darken-2"> Save </button>
                        </div>
                        <div class="col l2 m2 s2 ">
                            <a href="/biltihistory" class="btn white teal-text"> Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(function(){
            $(".biltihistory form").submit(function(ev){
                var newnumber=$("#newnumber").val();
                var adda=$("#adda").val();
                var invoiceid=$("#invoiceid").val();
                if(!newnumber || !newnumber.trim()){
                    Materialize.toast('Please enter valid bilti number',3000,'red');
                    ev.preventDefault();
                    return;
                }
                else if(!adda|| !adda.trim()){
                    Materialize.toast('Please enter valid adda',3000,'red');
                    ev.preventDefault();
                    return;
                }
                else if(!invoiceid|| !invoiceid.trim() || isNaN(invoiceid)){
                    Materialize.toast('Please enter valid invoice',3000,'red');
                    ev.preventDefault();
                    return;
                }
            });
        });
    </script>
@endsection