@extends('admin.master')

@section('admin_content')
    <style>
        .customers .card-header{
            padding: 10px 10px 10px 10px;
        }
        #modalDeleteCustomer{
            margin-top: 10%;
        }
    </style>
    <div id="modalAddCustomer" class="modal">
        <form action="/customer/add" method="post">
            {{csrf_field()}}
            <div class="modal-content">
                <h4>Add Customer: </h4>
                <div class="row">
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="name" name="name">
                        <label for="name">
                            Customer Name :
                        </label>
                    </div>
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="phone" name="phone">
                        <label for="phone">
                            Phone Number:
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                        <input type="text" id="address" name="address">
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
                        <button type="button" class="modal-action modal-close btn white teal-text" onclick="return false;"> Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="modalDeleteCustomer" class="modal">
        <form action="/customer/delete" method="post">
            {{csrf_field()}}
            <input type="hidden" class="entityid" name="id"/>
            <div class="modal-content center">
                <h5>Are you sure to delete customer? </h5>
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
    <div class="row customers">
        <div class="col l10 m10 s10">
            <div class="card">
                <div class="cyan darken-2 card-image white-text center card-header">
                    <h5>Customers</h5>
                    <a href="#modalAddCustomer" class="btn-floating green  halfway-fab"><i class="material-icons">add</i></a>
                </div>
                <div class="card-content">
                    @if(!empty($customers))
                        <table class="centered highlight">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($customers as $customer)
                                <tr>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$customer->phone}}</td>
                                    <td>{{$customer->address}}</td>
                                    <td>
                                        <a href="/customer/edit/{{$customer->id}}"><i class="material-icons">edit</i></a>
                                        <a href="/customer/{{$customer->id}}/details"><i class="material-icons green-text">open_in_new</i></a>
                                        <a href="#modalDeleteCustomer" data-entityid="{{$customer->id}}" data-linkaction="delete"><i class="material-icons red-text">delete_forever</i></a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <h5 align="center">No customer found</h5>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        @php
                            $entities=$customers;
                        @endphp
                        @include('admin.components.paginator')
                    @else
                        <h5>No customer found...!</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $("#modalAddCustomer form").submit(function (ev) {
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
            $("#modalDeleteCustomer form").submit(checkid);
            function checkid(ev){

                var id=$(this).find('.entityid').val();
                if(!id)
                {
                    Materialize.toast('Error while deleting record...!',3000,'red');
                    ev.preventDefault();
                }
            }
        });
    </script>
@endsection