@extends('admin.master')

@section('admin_content')
    <style>
        .products .card-header{
            padding: 10px 10px 10px 10px;
        }
        #modalAddProduct{
            overflow-y: scroll;
        }
        #modalDeleteProduct{
            margin-top: 10%;
        }
        .autocomplete {
            display: -ms-flexbox;
            display: flex;
        }
        .autocomplete .ac-dropdown .ac-hover {
            background: #eee;
        }
        .autocomplete .ac-input {
            -ms-flex: 1;
            flex: 1;
            min-width: 150px;
            padding-top: 0.6rem;
        }
        .autocomplete .ac-input input {
            height: 2.4rem;
        }

    </style>
    <input type="hidden" id="companies" value="{{$companies}}">
    <div id="modalAddProduct" class="modal">
        <form action="/product/add" method="post">
            {{csrf_field()}}
            <div class="modal-content">
                <h4>Add Product: </h4>
                <div class="row">
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="code" name="code">
                        <label for="code">
                            Product Code:
                        </label>
                    </div>
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <input type="text" id="description" name="description">
                        <label for="description">
                            Product Description:
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field  col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <div class="autocomplete" id="company_autocomplete">
                            <div class="ac-input">
                                <input type="text" id="company" name="company" data-activates="singledropdown" data-beloworigin="true" autocomplete="off">
                                <label for="company">
                                    Company:
                                </label>
                                <input type="hidden" name="companyid" id="companyid">
                            </div>
                            <ul id="singledropdown" class="dropdown-content ac-dropdown"></ul>
                        </div>
                    </div>
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                        <select id="producttype" name="type">
                            <option value="" disabled selected>Types</option>
                            <option value="kg">Kg</option>
                            <option value="pieces">Pieces</option>
                        </select>
                        <label for="producttype">
                           Choose Product Type:
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                            <input type="text" id="quantity" name="quantity" disabled>
                            <label for="quantity">
                                Pieces:
                            </label>

                    </div>
                    <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                            <input type="text" id="reorderrate" name="reorderrate">
                            <label for="reorderrate">
                                Reorder Rate:
                            </label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                        <select id="repositories" name="repositoryno">
                            <option value="" disabled selected>Repository</option>
                            @forelse($repositories as $repository)
                                <option value="{{$repository->number}}">{{$repository->number}}</option>
                            @empty
                            <option value="" disabled>No Repository found</option>
                            @endforelse

                        </select>
                        <label for="repositories">
                            Choose Repository:
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
    <div id="modalDeleteProduct" class="modal">
        <form action="/product/delete" method="post">
            {{csrf_field()}}
            <input type="hidden" class="entityid" name="code"/>
            <div class="modal-content center">
                <h5>Are you sure to delete product? </h5>
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
    <div class="row products">
        <div class="col l10 m10 s10">
            <div class="card">
                <div class="cyan darken-2 card-image white-text center card-header">
                    <h5>Products</h5>
                    <a href="#modalAddProduct" class="btn-floating green halfway-fab tooltipped" data-tooltip="Add Product"><i class="material-icons ">add</i></a>
                </div>
                <div class="card-content">
                    @if(!empty($products))
                        <table class="centered highlight">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Company</th>
                                <th>Type</th>
                                <th>Repository</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                           @forelse($products as $product)
                               <tr>
                                   <td>{{$product->code}}</td>
                                   <td>{{$product->description}}</td>
                                   <td>{{$product->company->name}}</td>
                                   <td>{{$product->type}}</td>
                                   <td>{{$product->repositoryno}}</td>
                                   <td>
                                       <a href="/product/edit/{{$product->code}}" class="tooltipped" data-tooltip="Edit"
                                         ><i class="material-icons">edit</i></a>
                                       <a href="#modalDeleteProduct"  data-entityid="{{$product->code}}" data-linkaction="delete" class="tooltipped" data-tooltip="Delete"><i class="material-icons red-text">delete_forever</i></a>
                                   </td>
                               </tr>
                           @empty
                               <tr>
                                   <td colspan="5">
                                       <h5>No product found</h5>
                                   </td>
                               </tr>
                           @endforelse
                            </tbody>
                        </table>
                        @php
                        $entities=$products;
                        @endphp
                        @include('admin.components.paginator')
                    @else
                        <h5>No product found</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('materializecss/js/jquery.materialize-autocomplete.js')}}"></script>
    <script>
        $(function(){
            $("#modalAddProduct form").submit(function(ev){
                var code=$("#code").val();
                var description=$("#description").val();
                var companyid=$("#companyid").val();
                var type=$("#producttype").val();
                var quantity=$("#quantity").val();
                var reorderrate=$("#reorderrate").val();
                var repository=$('#repositories').val();
                if(!code || !code.trim()){
                    Materialize.toast('Please enter product code');
                    ev.preventDefault();
                    return false;
                }
                if(!description|| !description.trim()){
                    Materialize.toast('Please enter product description');
                    ev.preventDefault();
                    return false;
                }
                if(!companyid|| !companyid.trim()){
                    Materialize.toast('Please choose product company');
                    ev.preventDefault();
                    return false;
                }
                if(!type || !type.trim()){
                    Materialize.toast('Please choose product type');
                    ev.preventDefault();
                    return false;
                }
                if(!quantity|| !quantity.trim()|| isNaN(quantity)){
                    Materialize.toast('Please enter valid product quantity');
                    ev.preventDefault();
                    return false;
                }
                if(!reorderrate|| !reorderrate.trim() || isNaN(reorderrate)){
                    Materialize.toast('Please enter valid product reorderrate');
                    ev.preventDefault();
                    return false;
                }
                if(!repository|| !repository.trim()){
                    Materialize.toast('Please choose product repository');
                    ev.preventDefault();
                    return false;
                }
            });
            $("#producttype").change(function(ev){
                if($(this).val()=="kg"){
                   $('label[for="quantity"]').text('Kilograms:');
                    $('#quantity').prop('disabled',false);
                }
                else if($(this).val()=="pieces"){
                    $('label[for="quantity"]').text('Pieces:');
                    $('#quantity').prop('disabled',false);
                }
                else{
                    $('#quantity').prop('disabled',true);
                }
            });
            var company=$("#company");
            var autocomplete=company.materialize_autocomplete({
                limit:4,
                multiple:{
                    enable:false
                },
                dropdown:{
                    el:"#singledropdown"
                },
                getData:function(value,callback){
                    initializeAutoComplete(value)
                },
                onSelect:function (item) {
                    $("#companyid").val(item.id);
                }
                
            });
            function initializeAutoComplete(input){
                var companies=JSON.parse($("#companies").val());
                var resultCache={};
                resultCache[input.toUpperCase().trim()]=[];
                $.each(companies,function(index,value){
                    if(value.name.toUpperCase().lastIndexOf(input)>-1){
                        resultCache[input.toUpperCase().trim()].push({
                            id:value.id,
                            text:value.name
                        });
                    }
                });
                company.materialize_autocomplete("option").resultCache=resultCache;
                company.trigger('input');
            }
            $("#modalDeleteProduct form").submit(checkEid);
            function checkEid(ev){
                var companyid=$(this).find('.entityid').val();
                if(!companyid)
                {
                    Materialize.toast('Error while deleting record...!',3000,'red');
                    ev.preventDefault();
                }
                //ev.preventDefault();
            }
        });
    </script>
@endsection