@extends('admin.master')

@section('admin_content')
    <style>
        .repositories .card-header{
            padding: 10px 10px 10px 10px;
        }
        #modalDeleteRepository{
            margin-top: 10%;
        }
        #modalAddRepository{
            overflow-y: hidden;
        }
    </style>
    <div id="modalAddRepository" class="modal">
        <form action="/repository/add" method="post" >
            {{csrf_field()}}
            <div class="modal-content">
                <h4>Add Repository: </h4>
                <div class="row">
                    <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                        <input type="text" id="number" name="number">
                        <label for="number">
                            Repository Number:
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4">
                        <button type="submit" class="btn green "> Save </button>
                    </div>
                    <div class="col l2 m2 s2 ">
                        <button type="button" class="modal-action modal-close btn white teal-text" onclick="return false;"> Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="modalDeleteRepository" class="modal">
        <form action="/repository/delete" method="post">
            {{csrf_field()}}
            <input type="hidden" class="entityid" name="number"/>
            <div class="modal-content center">
                <h5>Are you sure to delete repository? </h5>
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
    <div class="row repositories">
        <div class="col l10 m10 s10">
            <div class="card">
                <div class="cyan darken-2 card-image white-text center card-header">
                    <h5>Repositories</h5>
                    <a href="#modalAddRepository" class="btn-floating green halfway-fab tooltipped" data-tooltip="Add User"><i class="material-icons">add</i></a>
                </div>
                <div class="card-content">
                    @if(!empty($repositories))
                        <table class="centered highlight">
                            <thead>
                            <tr>
                                <th>Number</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($repositories as $repository)
                                <tr>
                                    <td>{{$repository->number}}</td>
                                    <td >
                                        <a href="/repository/edit/{{$repository->number}}" class="tooltipped" data-tooltip="Edit"><i class="material-icons">edit</i></a>
                                        <a href="#modalDeleteRepository" data-entityid="{{$repository->number}}" data-linkaction="delete" class="tooltipped" data-tooltip="Delete">
                                            <i class="material-icons red-text">delete_forever</i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <h5 align="center">No repository found</h5>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        @php
                            $entities=$repositories;
                        @endphp
                        @include('admin.components.paginator')
                    @else
                        <h5>No repository found</h5>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $("#modalAddRepository form").submit(function (ev) {
                var number=$("#number").val();
                if(!number|| !number.trim() ){
                    Materialize.toast('Please enter valid number...!',3000,'red');
                    ev.preventDefault();
                    return false;
                }
            });
            $("#modalDeleteRepository form").submit(checkUid);
            function checkUid(ev){
                var repositoryid=$(this).find('.entityid').val();
                if(!repositoryid)
                {
                    Materialize.toast('Error while deleting record...!',3000,'red');
                    ev.preventDefault();
                }
            }
        });
    </script>
@endsection