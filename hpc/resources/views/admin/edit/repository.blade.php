@extends('admin.master')
@section('admin_content')
    <style>
        .card-header{
            padding: 10px;
        }
    </style>
    <div class="row repository">
        <div class="card col l10 m10 s10">
            <div class="cyan darken-2 center-align white-text card-header">
                <h5>Edit Repository</h5>
            </div>
            <div class="card-content">
                <form action="/repository/update" method="post">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                            <input type="hidden" id="oldnumber" name="oldnumber" value="{{$repository->number}}">
                            <input type="text" id="newnumber" name="newnumber" value="{{$repository->number}}">
                            <label for="newnumber">
                                Repository Number:
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4">
                            <button type="submit" class="btn blue darken-2"> Save </button>
                        </div>
                        <div class="col l2 m2 s2 ">
                            <a href="/repositories" class="btn white teal-text"> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $(".user form").submit(function (ev) {
                var number=$("#newnumber").val();
                if(!number|| !number.trim() ){
                    Materialize.toast('Please enter repository number...!',3000,'red');
                    ev.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endsection