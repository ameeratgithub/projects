<style>
    #cart .card-header{
        padding: 15px 20px 15px 20px;
        margin-bottom: 25px;font-size: larger;
    }
    #cart .card-content{
        padding: 0 0 10px 0;overflow-y: auto;max-height: 40%;
    }
    #cart .card-content .row.cyan{
        margin-bottom: 10px;padding: 10px 5px 10px 5px;
    }

    .infochips .col{
        background-color: rgba(146, 120, 148, 0.89);border-radius: 3px;margin-right: 5px;
        padding:15px 8px 15px 8px;
    }
    .infochips .col.paid{
        background-color: #e0f7fa;color: #00897b;
    }
    .infochips .col.paid,.infochips .col.grandtotal{
        font-weight: bold;
    }
    .infochips .col.row .col{
        background-color: transparent;padding: 0;
    }
    .infochips .col.row .col input[type=text]{
        height: auto;margin: 0;border-bottom-color:rgba(231, 244, 239, 0.89) ;
    }
    #cart .totalitems span{
        float: left;
        background-color: #0f9d58;
        border-radius: 100%;
        padding: 1% 5% 1% 5%;margin: -1% 0 0 25%;
        width: 40%;
    }
    .checkout{
        margin: 0;padding: 0;
        display: none;
    }
</style>
<div id="modalCash" class="modal">
    <div class="modal-content">
        <h4 class="center-align">Add Customer Details - Cash: </h4>
        <div class="row">
            <div class="input-field col s6 m6 l6 offset-l3 offset-m3 offset-s3 ">
                <input type="text" id="" name="">
                <label for="">
                    Quantity:
                </label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3">
                <input type="text" id="" name="">
                <label for="">
                    Rate:
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col l2 m2 s2 offset-l4 offset-m4 offset-s4">
                <button type="submit" class="btn green"> Add </button>
            </div>
            <div class="col l2 m2 s2 ">
                <button type="button" class="modal-action modal-close btn white teal-text" onclick="return false;"> Cancel</button>
            </div>
        </div>
    </div>
</div>
<div id="cart" class="card center-align">
    <div class="cyan white-text row card-header">
        <div class="col s1 m1 l1">Code</div>
        <div class="col s3 m3 l3">Description</div>
        <div class="col s2 m2 l2">Unit</div>
        <div class="col s1 m1 l1">Rate</div>
        <div class="col s1 m1 l1">Quantity</div>
        <div class="col s2 m2 l2">Total</div>
        <div class="col s2 m2 l2 totalitems center-align"><span>0</span>
            <a href="javascript:void(0)" class="red-text">
                <i class="material-icons ">layers_clear</i>
            </a>
        </div>
    </div>
    <div class="teal-text card-content">
    </div>
</div>
<div class="card">
    <div class="white-text card-content">
        <div class="row infochips">

            <div class="col s3 m3 l3 row paid"><div class="col l3">Paid : </div><div class="col l8"><input type="text"></div></div>
            <div class="col s3 m3 l3 remained">Remaining : <span>10</span></div>
            <div class="col s2 m2 l2 return">Return : <span>0</span></div>
            <div class="col s3 m3 l3 grandtotal">Total: <span>0</span></div>
        </div>
    <br/>
        <div class="row checkout">
            <div class="col l3 m3 s3 offset-s8 offset-m8 offset-l8">
                <a href="/cashier/checkout" type="submit" id="checkOut" class="btn green">Check out
                    <i class="material-icons right">chevron_right</i>
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        getCartItems();
        $('.totalitems a').click(function(){
            localStorage.removeItem('cartitems');
            getCartItems();
        });
        $("#modalCash").modal();
        $(".paid input[type=text]").keydown(function(ev){
            var numberKey=ev.keyCode>=48 && ev.keyCode<=57;
            var backSpace=ev.keyCode==8;
            var arrows=ev.keyCode==37 || ev.keyCode==39;
            var ctrlA=ev.ctrlKey && ev.keyCode==65;
            if(!numberKey && !backSpace && !arrows && !ctrlA){
                ev.preventDefault();
                ev.stopImmediatePropagation();
                return false;
            }
        }).keyup(function(ev){
            var grandTotal=Number($(".grandtotal span").text());
            var input=Number($(this).val());
            var remained=grandTotal-input;
            if(remained<0){
                $('.remained span').text('0');
                $('.return span').text((input-grandTotal));
            }
            else {
                $('.remained span').text(remained);
                $('.return span').text('0');
            }
        });

        $("#checkOut").click(function(ev){
            ev.preventDefault();
            var sale={
                grandTotal:$('.grandtotal span').text(),
                paid:$('.paid input').val(),
                remaining:$('.remained span').text(),
                cartItems:JSON.parse(localStorage.getItem('cartitems'))
            };
            localStorage.setItem('sale',JSON.stringify(sale));
            window.location='/cashier/checkout';
        });
    });
    function getCartItems(){
        $("#cart .card-content").empty();
        var cartitems=localStorage.getItem('cartitems');
        if(cartitems){
            cartitems=JSON.parse(cartitems);
            if(cartitems.length>0)
            {
                $('.checkout').css('display','block');
                $('#cart .totalitems span').text(cartitems.length);
                var grandTotal=0;
                $.each(cartitems,function(index,cartitem){
                    grandTotal+=cartitem.total;
                    $("#cart .card-content").append(renderCartItem(cartitem));
                });
                $('.grandtotal span').text(grandTotal);
                $('.remained span').text(grandTotal);
            }
            else displayNoItem();
        }
        else displayNoItem();
    }
    function displayNoItem(){
        var p=$('<p/>').addClass('red-text center-align').html('<b>No cart item found...! </b>');
        $("#cart .card-content").append(p);
        $('#cart .totalitems span').text('0');
        $('.grandtotal span').text('0');
        $('.remained span').text('0');
        $('.checkout').css('display','none');
    }
    function renderCartItem(cartItem){
        var colClass2="col s2 m2 l2";
        var colClass1="col s1 m1 l1";
        var row=$('<div/>').addClass("cyan lighten-5 row hoverable").data('cartItem',cartItem);
        var code=$('<div/>').addClass(colClass1).text(cartItem.code);
        var description=$('<div/>').addClass("col s3 m3 l3").text(cartItem.description);
        var unit=$('<div/>').addClass(colClass2).text(cartItem.unit);
        var rate=$('<div/>').addClass(colClass1).text(cartItem.rate);
        var quantity=$('<div/>').addClass(colClass1).text(cartItem.quantity);
        var total=$('<div/>').addClass(colClass2).text(cartItem.total);
        var removeItem=$('<div/>').addClass(colClass1);
        var a_remove=$('<a/>').attr('href','javascript:void(0)').click(removeCartItem);
        var i_remove=$('<i/>').addClass('material-icons').text('remove_shopping_cart');
        removeItem=appendItems(removeItem,[appendItems(a_remove,[i_remove])]);
        return appendItems(row,[code,description,unit,rate,quantity,total,removeItem]);
    }
    function removeCartItem(){
        var element=$(this).closest('.row');
        var cartItem=element.data('cartItem');
        var cartItems=JSON.parse(localStorage.getItem('cartitems'));
        cartItems= $.grep(cartItems,function(item,index){
            return item.code!=cartItem.code;
        });
        localStorage.setItem('cartitems',JSON.stringify(cartItems));
        getCartItems();
    }
    function appendItems(parent,childs){
        $.each(childs,function(index,child){
            parent.append(child);
        });
        return parent;
    }
</script>
