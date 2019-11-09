@extends('admin.master')

@section('admin_content')
    <style>
        .users .card-header{
            padding: 10px 10px 10px 10px;
        }
        #modalResetPassword,#modalDeleteUser{
            margin-top: 10%;
        }
        #modalAddUser{
            overflow-y: hidden;
        }
    </style>
    <div id="modalAddUser" class="modal">
        <form action="/user/add" method="post" >
            {{csrf_field()}}
            <div class="modal-content">
                <h4>Add User: </h4>
                <div class="row">
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="name" name="name">
                        <label for="name">
                            User Full Name :
                        </label>
                    </div>
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="email" name="email">
                        <label for="email">
                            Email :
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="tel" id="phone" name="phone">
                        <label for="phone">
                            Phone Number :
                        </label>
                    </div>
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="address" name="address">
                        <label for="address">
                            Address :
                        </label>
                    </div>

                </div>
                <div class="row">
                    <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                        <select id="userRole" name="role">
                            <option value="" disabled selected>Role</option>
                            <option value="admin">Admin</option>
                            <option value="cashier">Cashier</option>
                        </select>
                        <label for="userRole">
                            Choose user role :
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
    <div id="modalResetPassword" class="modal">
        <form action="/user/resetPassword" method="post">
            {{csrf_field()}}
            <input type="hidden" class="entityid" name="userid"/>
            <div class="modal-content center">
                <h5>Are you sure to reset user password? </h5>
                <br/><br/>
                <div class="row">
                    <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4">
                        <button type="submit" class="btn green"> Reset </button>
                    </div>
                    <div class="col l2 m2 s2">
                        <button class="btn modal-action modal-close white teal-text" onclick="return false;"> Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="modalDeleteUser" class="modal">
        <form action="/user/delete" method="post">
            {{csrf_field()}}
            <input type="hidden" class="entityid" name="userid"/>
            <div class="modal-content center">
                <h5>Are you sure to delete user? </h5>
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
    <div class="row users">
    <div class="col l10 m10 s10">
        <div class="card">
            <div class="cyan darken-2 card-image white-text center card-header">
                <h5>Users</h5>
                <a href="#modalAddUser" class="btn-floating green halfway-fab tooltipped" data-tooltip="Add User"><i class="material-icons">add</i></a>
            </div>
            <div class="card-content">
                    @if(!empty($users))
                    <table class="centered highlight">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Login</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->lastlogin?$user->lastlogin:"Not Available"}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    <a href="/user/edit/{{$user->id}}" class="tooltipped" data-tooltip="Edit"><i class="material-icons">edit</i></a>
                                        <a href="#modalResetPassword" data-linkaction="reset" data-entityid="{{$user->id}}"><i class="material-icons green-text">settings_backup_restore</i></a>
                                    @if(\Illuminate\Support\Facades\Auth::id()!==$user->id)
                                        <a href="#modalDeleteUser" data-entityid="{{$user->id}}" data-linkaction="delete" class="tooltipped" data-tooltip="Delete">
                                            <i class="material-icons red-text">delete_forever</i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <h5 align="center">No user found</h5>
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                    @php
                        $entities=$users;
                    @endphp
                    @include('admin.components.paginator')
                    @else
                        <h5>No user found</h5>
                    @endif

            </div>
        </div>
    </div>
</div>
    <script>
        $(function(){
           $("#modalAddUser form").submit(function (ev) {
               var name=$("#name").val();
               var email=$("#email").val();
               var phone=$("#phone").val();
               var address=$("#address").val();
               var role=$("#userRole").val();
               var nameRegex=/^[a-zA-Z\s]+$/i;
               var emailRegex=/^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
               var phoneRegex=/\d{4}[\s]\d{7}/i;
               if(!name|| !name.trim() || !nameRegex.test(name)){
                   Materialize.toast('Please enter valid name...!',3000,'red');
                   ev.preventDefault();
                   return false;
               }
               else if(!email || !email.trim() || !emailRegex.test(email)){
                   Materialize.toast('Please enter valid email...!',3000,'red');
                   ev.preventDefault();
                   return false;
               }
               else if(!phone || !phone.trim() || !phoneRegex.test(phone) ){
                   Materialize.toast('Please enter valid phone number...!',3000,'red');
                   ev.preventDefault();
                   return false;
               }
               else if(!address|| !address.trim() ){
                   Materialize.toast('Please enter valid address...!',3000,'red');
                   ev.preventDefault();
                   return false;
               }
               else if(!role|| !role.trim() ){
                   Materialize.toast('Please choose user role...!',3000,'red');
                   ev.preventDefault();
                   return false;
               }
           });
            $("#modalDeleteUser form").submit(checkUid);
            $("#modalResetPassword form").submit(checkUid);
            function checkUid(ev){
                var userid=$(this).find('.entityid').val();
                if(!userid){
                    Materialize.toast('Error while deleting record...!',3000,'red');
                    ev.preventDefault();
                }

            }
        });
    </script>
@endsection