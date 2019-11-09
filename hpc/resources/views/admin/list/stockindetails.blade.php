@extends('admin.master')

@section('admin_content')
    <style>
        .stockin .card-header{
            padding: 10px 10px 10px 10px;
        }
        #modalDeleteStockinDetails,#modalCloseStockinDetails{
            margin-top: 10%;
        }
        #a_closestockin{
            right: 68px;
        }
        .autocomplete {
            display: -ms-flexbox;
            display: flex;
        }
        .autocomplete .ac-input {
            -ms-flex: 1;
            flex: 1;
            min-width: 150px;
            padding-top: 0.6rem;
        }
        .autocomplete .ac-dropdown .ac-hover {
            background: #eee;
        }
        .autocomplete .ac-input input {
            height: 2.4rem;
        }
    </style>
    <input type="hidden" id="products" value="{{$products}}">
    {{--<input type="hidden" id="companies" value="{{$companies}}">--}}
    <div id="modalAddStockinDetails" class="modal">
        <form action="/stockindetails/add" method="post">
            {{csrf_field()}}
            <div class="modal-content">
                <h4>Add Stockin Details: </h4>
                <input type="hidden" name="stockinid" value="{{$stockin->id}}">
                {{--<div class="row">
                    <div class="input-field col s6 m6 l6 offset-l3 offset-m3 offset-s3 ">
                        <div class="autocomplete">
                            <div class="ac-input">
                                <input type="text" id="c_addstdet" name="company" data-activates="add_cdd" data-beloworigin="true" autocomplete="off">
                                <label for="c_addstdet">
                                    Company:
                                </label>
                                <input type="hidden" name="companyid" class="companyid" id="ci_addstdet">
                            </div>
                            <ul id="add_cdd" class="dropdown-content ac-dropdown"></ul>
                        </div>
                    </div>
                </div>--}}
                <div class="row">
                    <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3">
                        <div class="autocomplete product_autocomplete">
                            <div class="ac-input">
                                <input type="text" id="pc_addstdet" class="productcode" name="productcode" data-activates="add_dd" data-beloworigin="true" autocomplete="off">
                                <label for="pc_addstdet">
                                    Product:
                                </label>
                            </div>
                            <ul id="add_dd" class="dropdown-content ac-dropdown"></ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3">
                        <input type="text" id="q_addstdet" name="quantity">
                        <label for="q_addstdet" >
                            Quantity:
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
    <div id="modalDeleteStockinDetails" class="modal">
        <form action="/stockindetails/delete" method="post">
            {{csrf_field()}}
            <input type="hidden" class="entityid" name="id"/>
            <input type="hidden" name="stockinid" value="{{$stockin->id}}"/>
            <div class="modal-content center">
                <h5>Are you sure to delete stockin detail? </h5>
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
    <div id="modalCloseStockinDetails" class="modal">
        <form action="/stockin/close" method="post">
            {{csrf_field()}}
            <input type="hidden" class="entityid" name="id" value="{{$stockin->id}}"/>
            <div class="modal-content center">
                <h5>Are you sure to close stockin? </h5>
                <br/><br/>
                <div class="row">
                    <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4" style="width: 19%">
                        <button type="submit" class="btn red darken-2">Close</button>
                    </div>
                    <div class="col l2 m2 s2">
                        <button class="btn modal-action modal-close white teal-text" onclick="return false;"> Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="modalEditStockinDetails" class="modal">
        <form action="/stockindetails/update" method="post">
            {{csrf_field()}}
            <input type="hidden" id="stockindetailid" name="id">
            <div class="modal-content">
                <h4>Edit Stockin Details: </h4>
                {{--<div class="row">
                    <div class="input-field col s6 m6 l6 offset-l3 offset-m3 offset-s3 ">
                        <div class="autocomplete">
                            <div class="ac-input">
                                <input type="text" id="c_editstdet" name="company" data-activates="edit_cdd" data-beloworigin="true" autocomplete="off">
                                <label for="c_editstdet">
                                    Company:
                                </label>
                                <input type="hidden" name="companyid" class="companyid" id="ci_editstdet">
                            </div>
                            <ul id="edit_cdd" class="dropdown-content ac-dropdown"></ul>
                        </div>
                    </div>
                </div>--}}
                <div class="row">
                    <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3">
                        <div class="autocomplete product_autocomplete">
                            <div class="ac-input">
                                <input type="text" id="pc_editstdet" class="productcode" name="productcode" data-activates="edit_dd" data-beloworigin="true" autocomplete="off">
                                <label for="pc_editstdet" class="active">
                                    Product:
                                </label>
                            </div>
                            <ul id="edit_dd" class="dropdown-content ac-dropdown"></ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3">
                        <input type="text" id="q_editstdet" name="quantity">
                        <label for="q_editstdet">
                            Quantity:
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
    <div class="row stockin">
        <div class="col l10 m10 s10">
            <div class="card">
                <div class="cyan darken-2 card-image white-text center card-header">
                    <h5>Stockin Details</h5>
                    @if(!$stockin->closed)
                        <a id="a_closestockin" href="#modalCloseStockinDetails" class="btn-floating red darken-3 halfway-fab tooltipped" data-tooltip="Close"><i class="material-icons">grid_off</i></a>
                        <a href="#modalAddStockinDetails" class="btn-floating green halfway-fab"><i class="material-icons ">add</i></a>
                    @endif
                </div>
                <div class="card-content">
                    @if(!empty($stockin->details))
                        <table class="centered highlight">
                            <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Quantity</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($stockin->details as $stockindetail)
                                <tr>
                                    <td>{{$stockindetail->productcode}}</td>
                                    <td>{{$stockindetail->quantity}}</td>
                                    <td> @if(!$stockin->closed)

                                            <a href="#modalEditStockinDetails" data-entityid="{{$stockindetail->id}}" data-linkaction="edit"><i class="material-icons">edit</i></a>
                                            <a href="#modalDeleteStockinDetails" data-entityid="{{$stockindetail->id}}" data-linkaction="delete"><i class="material-icons red-text">delete_forever</i></a>

                                    @else
                                             N/A
                                    @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <h5 align="center">No stockin details found</h5>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    @else
                        <h5>No stockin details found</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('materializecss/js/jquery.materialize-autocomplete.js')}}"></script>
    <script>
        $(function(){
            var c_addstdet=$("#c_addstdet");
            var c_editstdet=$("#c_editstdet");
            var add_cac=c_addstdet.materialize_autocomplete(getCACOptions('#add_cdd'));
            var edit_cac=c_editstdet.materialize_autocomplete(getCACOptions('#edit_cdd'));
            function  getCACOptions(ddid){
                return{
                    limit:4,
                    multiple:{
                        enable:false
                    },
                    dropdown:{
                        el:ddid
                    },
                    getData:function(value,callback){
                        var element='';
                        if(this.dropdown.el==="#add_cdd")
                            element=$('#c_addstdet');
                        else if(this.dropdown.el==="#edit_cdd")
                            element=$('#c_editstdet');
                        initializeCAutoComplete(value,element)
                    },
                    onSelect:function (item) {
                        $(".companyid").val(item.id);
                        $('.productcode').val('').materialize_autocomplete('option').resultCache={};
                        $('.dropdown-content').empty();
                    }
                };
            }
            function initializeCAutoComplete(input,element){
               /* var companies=JSON.parse($("#companies").val());
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
                element.materialize_autocomplete("option").resultCache=resultCache;
                element.trigger('input');*/
            }
        })
    </script>
    <script>
        $(function(){

            $("#modalAddStockinDetails form").submit(function(ev){
                var productcode=$("#pc_addstdet").val();
                var quantity=$("#q_addstdet").val();
                if(!productcode || !productcode.trim()){
                    Materialize.toast('Please enter valid product',3000,'red');
                    ev.preventDefault();
                    return;
                }
                else if(!quantity|| !quantity.trim()){
                    Materialize.toast('Please enter valid quantity',3000,'red');
                    ev.preventDefault();
                    return;
                }
            });
            $("#modalEditStockinDetails form").submit(function(ev){
                var stockindetailid=$("#stockindetailid").val();
                var productcode=$("#pc_editstdet").val();
                var quantity=$("#q_editstdet").val();
                if(!productcode || !productcode.trim()){
                    Materialize.toast('Please enter valid product',3000,'red');
                    ev.preventDefault();
                    return;
                }
                else if(!quantity|| !quantity.trim()){
                    Materialize.toast('Please enter valid quantity',3000,'red');
                    ev.preventDefault();
                    return;
                }
                else if(!stockindetailid|| !stockindetailid.trim()){
                    Materialize.toast('Something is gone wrong',3000,'red');
                    ev.preventDefault();
                    return;
                }
            });
            var pc_addstdet=$("#pc_addstdet");
            var pc_editstdet=$("#pc_editstdet");
            var add_ac=pc_addstdet.materialize_autocomplete(getACOptions('#add_dd'));
            var edit_ac=pc_editstdet.materialize_autocomplete(getACOptions('#edit_dd'));
            $("#modalDeleteStockinDetails form").submit(checkEid);
            function checkEid(ev){
                var companyid=$(this).find('.entityid').val();
                if(!companyid)
                {
                    Materialize.toast('Error while deleting record...!',3000,'red');
                    ev.preventDefault();
                }
            }
        });
        function initializeAutoComplete(input,element){
            var products=JSON.parse($("#products").val());
            var resultCache={};
            resultCache[input.toUpperCase().trim()]=[];
            $.each(products,function(index,value){
                if(value.code.toUpperCase().lastIndexOf(input)>-1){
                    //var specifiedcompany='';
                    //if(element.attr('id')==='pc_addstdet')
                    //specifiedcompany=$('#ci_addstdet').val();
                    //else if(element.attr('id')==='pc_editstdet')
                    //    specifiedcompany=$('#ci_editstdet').val();
                    //if(value.companyid==specifiedcompany)
                    resultCache[input.toUpperCase().trim()].push({
                        id:value.code,
                        text:value.code
                    });

                }
            });
            element.materialize_autocomplete("option").resultCache=resultCache;
            element.trigger('input');
        }
        function  getACOptions(ddid){
            return{
                limit:4,
                multiple:{
                    enable:false
                },
                dropdown:{
                    el:ddid
                },
                getData:function(value,callback){
                    var element='';
                    if(this.dropdown.el==="#add_dd")
                            element=$('#pc_addstdet');
                    else if(this.dropdown.el==="#edit_dd")
                        element=$('#pc_editstdet');
                    initializeAutoComplete(value,element)
                }
            };
        }
    </script>
@endsection
@section('page_script')
<script>
    $(function(){
        $("#modalEditStockinDetails").modal({
            ready:function(modal,trigger){
                var elements=$(trigger).parent().siblings();
                var productcode=$(elements[0]).text();
                var quantity=$(elements[1]).text();
                $('#stockindetailid').val($(trigger).data('entityid'));
                $("#q_editstdet").val(quantity);
                $('#pc_editstdet').val(productcode);

            }
        });
        @if(!$stockin->closed)
        $("#modalAddStockinDetails").modal('open');
        @endif
    });
</script>
@endsection