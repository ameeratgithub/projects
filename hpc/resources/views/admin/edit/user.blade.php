@extends('admin.master')
@section('admin_content')
    <style>
        .card-header{
            padding: 10px;
        }
    </style>
    <div class="row user">
        <div class="card col l10 m10 s10">
            <div class="cyan darken-2 center-align white-text card-header">
                <h5>Edit User</h5>
            </div>
            <div class="card-content">
                <form action="/user/update" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="userid" value="{{$user->id}}">
                    <div class="row">
                        <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                            <input type="text" id="name" name="name" value="{{$user->name}}">
                            <label for="name">
                                User Full Name :
                            </label>
                        </div>
                        <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                            <input type="text" id="email" name="email" disabled value="{{$user->email}}">
                            <label for="email">
                                Email :
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                            <input type="tel" id="phone" name="phone" value="{{$user->phone}}">
                            <label for="phone">
                                Phone Number :
                            </label>
                        </div>
                        <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                            <input type="text" id="address" name="address" value="{{$user->address}}">
                            <label for="address">
                                Address :
                            </label>
                        </div>

                    </div>
                    <div class="row">
                        <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                            <select id="userRole" name="role">
                                <option value="" disabled>Role</option>
                                <option value="admin" {{$user->role=="admin"?"selected":""}}>Admin</option>
                                <option value="cashier" {{$user->role=="cashier"?"selected":""}}>Cashier</option>
                            </select>
                            <label for="userRole">
                                Choose user role :
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4">
                            <button type="submit" class="btn blue darken-2"> Save </button>
                        </div>
                        <div class="col l2 m2 s2 ">
                            <a href="/users" class="btn white teal-text"> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $(".user form").submit(function (ev) {
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
        });
    </script>
@endsection