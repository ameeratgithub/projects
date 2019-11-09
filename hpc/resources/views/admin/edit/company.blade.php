@extends('admin.master')

@section('admin_content')
    <style>
        .card-header{
            padding: 10px 10px 10px 10px;
        }
    </style>
    <div class="row company">
        <div class="col card l10 m10 s10">
            <form action="/company/update" method="post">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{$company->id}}">
                <div class="cyan darken-2 center-align card-header white-text">
                    <h5>Edit Company</h5>
                </div>
                <div class="card-content">
                    <div class="row">
                        <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                            <input type="text" id="name" name="name" value="{{$company->name}}">
                            <label for="name">
                                Company Name :
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                            <input type="text" id="abbreviation" name="abbreviation" value="{{$company->abbreviation}}">
                            <label for="abbreviation">
                                Abbreviation :
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4">
                            <button type="submit" class="btn blue darken-2"> Save </button>
                        </div>
                        <div class="col l2 m2 s2 ">
                            <a href="/companies" class="btn white teal-text"> Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(function(){
            $(".company form").submit(function(ev){
                var name=$("#name").val();
                var abbreviation=$("#abbreviation").val();
                if(!name || !name.trim()){
                    Materialize.toast('Please enter valid company name',3000,'red');
                    ev.preventDefault();
                    return;
                }
                else if(!abbreviation || !abbreviation.trim()){
                    Materialize.toast('Please enter valid company abbreviation',3000,'red');
                    ev.preventDefault();
                    return;
                }
            });
        });
    </script>
@endsection