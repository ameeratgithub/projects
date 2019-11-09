@extends('admin.master')
@section('admin_content')
    <style>
        .card-header{
            padding: 10px;
        }
    </style>
    <div class="row customer">
        <div class="card col l10 m10 s10">
            <div class="cyan darken-2 center-align white-text card-header">
                <h5>Edit Customer</h5>
            </div>
            <div class="card-content">
                <form action="/customer/update" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$customer->id}}">
                        <div class="row">
                            <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                                <input type="text" id="name" name="name" value="{{$customer->name}}">
                                <label for="name">
                                    Customer Name :
                                </label>
                            </div>
                            <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                                <input type="text" id="phone" name="phone" value="{{$customer->phone}}">
                                <label for="phone">
                                    Phone Number:
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                                <input type="text" id="address" name="address" value="{{$customer->address}}">
                                <label for="address">
                                    Customer Address:
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4">
                                <button type="submit" class="btn green"> Save </button>
                            </div>
                            <div class="col l2 m2 s2 ">
                                <a class="btn white teal-text" href="/customers">Cancel</a>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $(".customer form").submit(function (ev) {
                var name=$("#name").val();
                var phone=$("#phone").val();
                var address=$("#address").val();
                var nameRegex=/^[a-zA-Z\s]+$/i;
                var phoneRegex=/\d{4}[\s]\d{7}/g;
                if(!name|| !name.trim() || !nameRegex.test(name)){
                    Materialize.toast('Please enter valid name...!',3000,'red');
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
            });
        });
    </script>
@endsection