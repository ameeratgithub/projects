<html>
<head>
    <link href="{{asset('materializecss/css/materialize.min.css')}}" rel="stylesheet">
    <script language="JavaScript" type="text/javascript" src="{{asset('js/jquery-3.2.1.js')}}"></script>
    <script language="JavaScript" type="text/javascript" src="{{asset('materializecss/js/materialize.min.js')}}"></script>
    <style>
        body{
            background: url("images/bg-23.jpg") no-repeat;
            background-size: cover;
        }
        .card{

            border-radius: 10px;
        }
        .card-header{
            background-color: #873aff;padding: 30px 15px 30px 30px;color: whitesmoke;
            border-radius: 0px 0px 5px 5px;
        }
    </style>
    <script>
        $(function () {
           $("#form_login").submit(function (ev) {
               var email=$("#email").val();
               var password=$("#password").val();
               email=email.trim();password=password.trim();
               if(!email){
                   Materialize.toast('Please Enter Valid Email...!',3000,'red');
                   ev.preventDefault();
                   return;
               }
               else if(!password){
                   Materialize.toast('Please Enter Password...!',3000,'red');
                   ev.preventDefault();
                   return;
               }


           });
        });
    </script>
</head>
<body>
<br/><br/><br/>
@include('admin.components.actionmessage')
<form id="form_login" action="/login" method="post">
    {{csrf_field()}}
    <div class="row">
        <div class="col l4 m4 s4  offset-l4 offset-m4 offset-s4   card">
            <div class="card-header">
                <h4>SIGN IN</h4>
            </div>
            <div class="card-content">
                <div class="row">
                    <div class="col l10 m10 s10 offset-l1 offset-m1 offset-s1 input-field">
                        <input type="text" id="email" name="email">
                        <label for="email">
                            Email :
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col l10 m10 s10 offset-l1 offset-m1 offset-s1 input-field">
                        <input type="password" id="password" name="password">
                        <label for="password">
                            Password :
                        </label>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col l5 m5 s5 offset-l4 offset-m4 offset-s4">
                        <button type="submit" class="btn blue darken-3 waves-effect" id="submit_login">
                            SIGN IN
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>