<style>
    nav{
        height: 54px;
        line-height: 54px;
    }
    nav .nav-wrapper .company-name{
        font-size: 1.4em;font-weight: bold;
        margin-left: 2%;
    }
    nav .nav-wrapper .role-name{
        font-size: 1.4em;
        margin-left: 30%;
    }
    nav .nav-wrapper ul.right{
        margin-right: 5%;height: inherit;
    }
    nav .nav-wrapper ul.right li{
        margin-right: 35px;
    }
    .btn-logout, .btn-changepassword{
        width: 0;height: 0;padding: 0;
        background-color: transparent;border: 0;outline: none;
    }
    .btn-logout i.material-icons,.btn-changepassword i.material-icons{
        margin-top: -5px;
    }
    .modal{
        overflow-y: hidden;
    }
</style>
@include('admin.components.actionmessage')
<div id="modalChangePassword" class="modal">
    <form action="/changepassword" method="post">
        {{csrf_field()}}
        <div class="modal-content">
            <h4>Change Password : </h4>
            <div class="row">
                <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                    <input type="password" id="oldpassword" name="oldpassword">
                    <label for="oldpassword">
                        Old Password :
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                    <input type="password" id="newpassword" name="newpassword">
                    <label for="newpassword">
                        New Password :
                    </label>
                </div>
                <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                    <input type="password" id="confirmpassword" name="confirmpassword">
                    <label for="confirmpassword">
                        Re-enter Password :
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4">
                    <button type="submit" class="btn blue darken-2"> Save </button>
                </div>
                <div class="col l2 m2 s2">
                    <button class=" modal-action modal-close btn white teal-text" onclick="return false;"> Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="modalChangeSelf" class="modal keepData">
    <form action="/updateself" method="post">
        {{csrf_field()}}
        <div class="modal-content">
            <h4>Change Data : </h4>
            <div class="row">
                <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                    <input type="text" id="selfname" name="selfname" value="{{$self->name}}" disabled>
                    <label for="selfname">
                        Company Name :
                    </label>
                </div>
                <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                    <input type="text" id="selfptclno" name="selfptclno" value="{{$self->ptclno}}">
                    <label for="selfptclno">
                        Ptcl No :
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                    <input type="text" id="selfmobileno" name="selfmobileno" value="{{$self->mobileno}}">
                    <label for="selfmobileno">
                        Mobile Number :
                    </label>
                </div>
                <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 " >
                    <input type="text" id="selfaddress" name="selfaddress" value="{{$self->address}}">
                    <label for="selfaddress">
                        Address :
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4">
                    <button type="submit" class="btn blue darken-2"> Save </button>
                </div>
                <div class="col l2 m2 s2">
                    <button class=" modal-action modal-close btn white teal-text" onclick="return false;"> Cancel</button>
                </div>
            </div>
        </div>
    </form>
</div>
<nav class="blue">
    <div class="nav-wrapper">
        <span class="company-name"> <a href="#modalChangeSelf">Hafiz Plastic Centre</a></span>
        <span class="role-name ">Admin</span>
        <ul class="right">
            <li>
                <button class="btn-changepassword tooltipped" data-tooltip="Change Password" data-position="left" data-target="modalChangePassword"><i class="material-icons">settings</i></button>
            </li>
            <li>
                <form action="/logout" method="post">
                    {{csrf_field()}}
                    <button type="submit" class="btn-logout">
                        <i class="material-icons tooltipped" data-tooltip="Log Out">exit_to_app</i>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>
<script>
    $(function(){
        $("#modalChangePassword form").submit(function(ev){
            var oldpassword=$("#oldpassword").val();
            var newpassword=$("#newpassword").val();
            var confirmpassword=$("#confirmpassword").val();
            if(!oldpassword || !oldpassword.trim()){
                Materialize.toast('Please enter old password...!',3000,'red');
                ev.preventDefault();
                return;
            }
            else if(!newpassword|| !newpassword.trim()){
                Materialize.toast('Please enter new password...!',3000,'red');
                ev.preventDefault();
                return;
            }
            else if(!confirmpassword|| !confirmpassword.trim()){
                Materialize.toast('Please re-enter new password...!',3000,'red');
                ev.preventDefault();
                return;
            }
            else if(newpassword!==confirmpassword){
                Materialize.toast('Password doesn\'t match...!',3000,'red');
                ev.preventDefault();
                return;
            }
        });
    });
</script>