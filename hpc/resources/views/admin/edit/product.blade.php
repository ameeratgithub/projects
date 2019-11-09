@extends('admin.master')
@section('admin_content')
    <style>
        .card-header{
            padding: 10px;
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
    <div class="row products">
        <div class="card col l10 m10 s10">
            <div class="cyan darken-2 center-align white-text card-header">
                <h5>Edit Product</h5>
            </div>
            <div class="card-content">
                <form action="/product/update" method="post">
                    {{csrf_field()}}
                        <div class="row">
                            <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                                <input type="hidden" name="oldcode" value="{{$product->code}}">
                                <input type="text" id="code" name="newcode" value="{{$product->code}}">
                                <label for="code">
                                    Product Code:
                                </label>
                            </div>
                            <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                                <input type="text" id="description" name="description" value="{{$product->description}}">
                                <label for="description">
                                    Product Description:
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field  col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                                <div class="autocomplete">
                                    <div class="ac-input">
                                        <input type="text" id="company" value="{{$product->company->name}}" name="company" data-activates="singledropdown" data-beloworigin="true" autocomplete="off">
                                        <label for="company">
                                            Company:
                                        </label>
                                        <input type="hidden" name="companyid" id="companyid" value="{{$product->companyid}}" >
                                    </div>
                                    <ul id="singledropdown" class="dropdown-content ac-dropdown"></ul>
                                </div>

                            </div>
                            <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                                <select id="producttype" name="type">
                                    <option value="" disabled>Types</option>
                                    <option value="kg" {{$product->type=="kg"?"selected":""}}>Kg</option>
                                    <option value="pieces" {{$product->type=="pieces"?"selected":""}}>Pieces</option>
                                </select>
                                <label for="producttype">
                                    Choose Product Type:
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                                <input type="text" id="quantity" name="quantity" value="{{$product->quantity}}">
                                <label for="quantity">
                                    Pieces:
                                </label>
                            </div>
                            <div class="input-field col l5 m5 s5 offset-l1 offset-m1 offset-s1 ">
                                <input type="text" id="reorderrate" name="reorderrate" value="{{$product->reorderrate}}">
                                <label for="reorderrate">
                                    Reorder Rate:
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 ">
                                <select id="repositories" name="repositoryno">
                                    <option value="{{$product->repositoryno}}" selected>{{$product->repositoryno}}</option>
                                    <optgroup label="All">
                                        @forelse($repositories as $repository)
                                            <option value="{{$repository->number}}">{{$repository->number}}</option>
                                        @empty
                                            <option value="" disabled>No Repository found</option>
                                        @endforelse
                                    </optgroup>

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
                                <a href="/products" class="btn white teal-text"> Cancel</a>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{asset('materializecss/js/jquery.materialize-autocomplete.js')}}"></script>
    <script>
        $(function(){
            $(".products form").submit(function(ev){
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
                if(!quantity|| !quantity.trim() || isNaN(quantity)){
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
        });
    </script>
@endsection