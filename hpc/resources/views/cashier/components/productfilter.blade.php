<style>
    .filterproduct{
        margin-top: -1%;
    }
    .filterproduct .card{
        margin: 0;
    }
    .filterproduct .card.back{
        z-index: -1;
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
        /*min-width: 150px;*/
        padding-top: 0.6rem;
    }
    .autocomplete .ac-input input {
        height: 2.4rem;margin-bottom:0;
    }
    .filterproduct .card:nth-child(2) .card-content{
        padding-top: 0;
    }
    .filterproduct .card:nth-child(2) .card-content .input-field {
        padding: 0;
    }
    #productlist.row{
        padding: 0 !important;
    }
    .collection{
        height: 250px;border: none;padding: 0;overflow-y: auto;
    }
    .collection .collection-item{
        border: none;margin-bottom: 2px;
    }
    .collection .collection-item:hover{
        background-color: rgba(15, 244, 236, 0.19);
    }
    .collection .collection-item i{
        font-size: large;margin-top: 5px;
    }
</style>
<input type="hidden" id="products" value="{{$products}}">
<input type="hidden" id="companies" value="{{$companies}}">
<div id="modalAddToCart" class="modal">
        <div class="modal-content">
            <h4 class="center-align">Add Cart Details for <span class="teal-text"></span></h4>
            <p class="center-align reordernote red-text" style="display: none"><b>Note:- Your product stock is less than reorder rate. Please reorder product.</b></p>
            <div class="row">
                <div class="input-field col s6 m6 l6 offset-l3 offset-m3 offset-s3 ">
                    <input type="text" id="quantity" name="quantity">
                    <label for="quantity">
                        Quantity:
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3">
                            <input type="text" id="rate" name="rate">
                            <label for="rate">
                                Rate:
                            </label>
                </div>
            </div>
            <div class="row">
                <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4">
                    <button id="btnAddToCart" type="submit" class="btn green"> Add </button>
                </div>
                <div class="col l2 m2 s2 ">
                    <button type="button" class="modal-action modal-close btn white teal-text" onclick="return false;"> Cancel</button>
                </div>
            </div>
        </div>
</div>
<div class="filterproduct ">
    <div class="card cyan lighten-1 white-text back">
        <div class="card-content">
            <span class="card-title center-align">Add Product to Cart</span>
        </div>
    </div>
    <div class="card blue lighten-5 teal-text actions">
        <div class="card-content">
            <br/>
            <div class="row">
                <div class="input-field  col l12 m12 s12 ">
                    <div class="autocomplete">
                        <div class="ac-input">
                            <input type="text" id="company" name="company" data-activates="companydropdown" data-beloworigin="true" autocomplete="off">
                            <label for="company">
                                Company:
                            </label>
                            <input type="hidden" name="companyid" id="companyid">
                        </div>
                        <ul id="companydropdown" class="dropdown-content ac-dropdown"></ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-field input-field  col l12 m12 s12">
                            <input type="text" id="product" name="productcode" disabled>
                            <label for="product">
                                Product:
                            </label>
                        <ul id="productdropdown" class="dropdown-content ac-dropdown"></ul>
                </div>
            </div>
        </div>
        <div class="row" id="productlist">
        <div class="col s12 m12 l12">
            <ul class="collection">
            </ul>
        </div>
        </div>
    </div>
</div>
<script src="{{asset('materializecss/js/jquery.materialize-autocomplete.js')}}"></script>
<script>
    $(function(){
        var products=JSON.parse($('#products').val());
        var companies=JSON.parse($("#companies").val());
        var company=$("#company").keyup(function(ev){
                if(ev.keyCode===8){
                    $("#productlist").find('.collection').empty();
                    $("#companyid").val('');
                    $('#product').prop('disabled',true);
                }
        });
        var ac_company=company.materialize_autocomplete({
            limit:4,
            multiple:{
                enable:false
            },
            dropdown:{
                el:"#companydropdown"
            },
            getData:function(value,callback){
                initializeCAutoComplete(value);
            },
            onSelect:function (item) {
                $("#companyid").val(item.id);
                $('.productcode').val('').materialize_autocomplete('option').resultCache={};
                $('.dropdown-content').empty();
                $('#product').prop('disabled',false);
                displayCompanyProducts($("#companyid").val());
            }
        });
        function initializeCAutoComplete(input){
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
        $("#product").keyup(function(){
            $("#productlist").find('.collection').empty();
            var value=$(this).val();
            var companyid=$("#companyid").val();
            var filteredProducts=[];
            if(!value || !value.trim())return;
            $.each(products,function(index,product){
                var pc=product.code.toLowerCase();
                if(pc.indexOf(value.toLowerCase())>-1)
                if(product.companyid==companyid)
                {
                    filteredProducts.push(product);
                }
            });
            renderItems(filteredProducts);
        });
        function displayCompanyProducts(companyId){
            $("#productlist").find('.collection').empty();
            var filteredProducts=[];
            $.each(products,function(index,product){
                    if(product.companyid==companyId)
                    {
                        filteredProducts.push(product);
                    }
            });
            renderItems(filteredProducts);
        }
        function renderItems(products){
            if(products.length>0)
            $.each(products,function(index,product){
                $("#productlist").find('.collection').append(getItem(product));
            });
           $('.tooltipped').tooltip();
        }
        function getItem(product){
            var li=$('<li/>').addClass('collection-item tooltipped').data('product',product).attr('data-tooltip',product.description);
            if(product.stock<=product.reorderrate)
                    li.addClass('red-text darken-4');
            var div=$('<div/>').text(product.code +"("+product.stock+")");
            var a=$('<a/>').addClass('secondary-content').attr('href','#modalAddToCart');
            var i=$('<i/>').addClass('material-icons').text('add_shopping_cart');
            a.append(i);
            div.append(a);li.append(div);
            return li;
        }
    });
</script>
<script>
    $(function(){
        var product=null;
        $('#modalAddToCart').modal({
            ready:function(modal,trigger){
                product=$(trigger).closest('.collection-item').data('product');
                $('.modal-content h4 span').text(product.code);
                if(product.stock<=product.reorderrate)
                        $('.reordernote').css('display','block');
                if(product.type=='kg')
                {
                    $(modal).find('label[for="rate"]').text('Rate of packet: ');
                }
                else if(product.type=='pieces')
                {
                    $(modal).find('label[for="rate"]').text('Rate of piece: ');
                }
            },
            complete:function(){
                $('.reordernote').css('display','none');
                $(this).find('input').val('');
            }
        });
        $("#btnAddToCart").click(function(ev){
            if(!product){
                Materialize.toast('Error occured in product...!',3000,'red');
                return;
            }
            var quantity=$('#quantity').val();
            var rate=$('#rate').val();
            if(!quantity || !quantity.trim() || isNaN(quantity)){
                Materialize.toast('Please enter valid quantity...!',3000,'red');
                return;
            }
            else if(!rate || !rate.trim() || isNaN(rate)){
                Materialize.toast('Please enter valid rate...!',3000,'red');
                return;
            }
            else if(quantity>product.stock){
                Materialize.toast('Your stock is less than your entered quantity...!',3000,'red');
                return;
            }
            var total=0;
            if(product.type==='kg')
                total=rate*quantity;
            else if(product.type==='pieces')
                    total=product.quantity*rate*quantity;
            if(!total){
                Materialize.toast('Your total should not be zero...!',3000,'red');
                return;
            }
            var cartitem={
              code:product.code,
                description:product.description,
                unit:product.quantity+' '+product.type,
                rate:rate,
                quantity:quantity,
                total:total
            };
            var cartitems=[];
            var itemExists=false;
            if(localStorage.getItem('cartitems'))
                cartitems= JSON.parse(localStorage.getItem('cartitems'));
            $.each(cartitems,function(index,item){
                if(cartitem.code===item.code){
                    itemExists=true;
                    var newQuantity=Number(item.quantity)+Number(cartitem.quantity);
                    if(newQuantity>Number(product.stock)){
                        Materialize.toast('Stock is less than new quantity.',3000,'red');
                        return false;
                    }
                    item.rate=cartitem.rate;
                    item.quantity=newQuantity;
                    if(product.type==='kg')
                        item.total=item.rate*item.quantity;
                    else if(product.type==='pieces')
                        item.total=product.quantity*item.rate*item.quantity;
                    return false;
                }
            });
            if(!itemExists)
            cartitems.push(cartitem);
            localStorage.setItem('cartitems',JSON.stringify(cartitems));
            $("#modalAddToCart").modal('close');
            getCartItems();
        });
    });
</script>