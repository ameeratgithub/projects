@extends('admin.master')

@section('admin_content')
    <style>
        .companies .card-header{
            padding: 10px 10px 10px 10px;
        }
        #modalDeleteCompany{
            margin-top: 10%;
        }
    </style>
    <div id="modalAddCompany" class="modal">
        <form action="/company/add" method="post">
            {{csrf_field()}}
            <div class="modal-content">
                <h4>Add Company: </h4>
                <div class="row">
                    <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                        <input type="text" id="name" name="name">
                        <label for="name">
                            Company Name :
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                        <input type="text" id="abbreviation" name="abbreviation">
                        <label for="abbreviation">
                            Abbreviation :
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
    <div id="modalDeleteCompany" class="modal">
        <form action="/company/delete" method="post">
            {{csrf_field()}}
            <input type="hidden" class="entityid" name="id"/>
            <div class="modal-content center">
                <h5>Are you sure to delete company? </h5>
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
    <div class="row companies">
        <div class="col l10 m10 s10">
            <div class="card">
                <div class="cyan darken-2 card-image white-text center card-header">
                    <h5>Companies</h5>
                    <a href="#modalAddCompany" class="btn-floating green halfway-fab"><i class="material-icons ">add</i></a>
                </div>
                <div class="card-content">
                    @if(!empty($companies))
                    <table class="centered highlight">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Abbreviation</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($companies as $company)
                        <tr>
                            <td>{{$company->name}}</td>
                            <td>{{$company->abbreviation}}</td>
                            <td>
                                <a href="/company/edit/{{$company->id}}"><i class="material-icons">edit</i></a>
                                <a href="#modalDeleteCompany" data-entityid="{{$company->id}}" data-linkaction="delete"><i class="material-icons red-text">delete_forever</i></a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <h5 align="center">No company found</h5>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    @php
                    $entities=$companies;
                    @endphp
                    @include('admin.components.paginator')
                    @else
                        <h5>No company found</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $("#modalAddCompany form").submit(function(ev){
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
            $("#modalDeleteCompany form").submit(checkEid);
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