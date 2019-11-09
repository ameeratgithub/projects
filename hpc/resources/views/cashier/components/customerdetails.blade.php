<style>
    #modalProceed{
        margin-top: 10%;
    }
    .checkRemainingAmount{
        margin: 0 15px 0 0;
    }
</style>
<div class="modal" id="modalProceed">
    <div class="modal-content center-align">
        <h5>Do you really want to proceed?</h5>

        <p class="red-text" style="display: none"><b>Note:- Customer has remaining amount...!</b></p>
        <br/>
        <div class="row">
            <div class="col l2 offset-l4">
                <button class="btn green white-text" id="proceedDone">Yes</button>
            </div>
            <div class="col l2">
                <button class="btn white teal-text modal-action modal-close">No</button>
            </div>
        </div>
    </div>
</div>
<form id="fm_proceed" action="/cashier/sales/save" method="post">
    {{csrf_field()}}
    <input type="hidden" name="sale" id="sale">
    <input type="hidden" name="customerid" id="customerid">
    <div class="row paymentmethod card teal lighten-5 teal-text z-depth-0">
        <div class="col l3 m3 s3 offset-l3">
            <h5>Payment Method : </h5>
        </div>
        <div class="input-field col l1 m1 s1">
            <input type="radio" class="with-gap" name="method" id="cash" value="cash" checked>
            <label for="cash">
                Cash
            </label>
        </div>
        <div class="input-field col l1 m1 s1">
            <input type="radio" class="with-gap" name="method" id="credit" value="credit">
            <label for="credit">
                Credit
            </label>
        </div>
    </div>
    <div id="customerDetails" class="card center-align">
        <div class="card-content">
            <div class="row">
                <div class=" input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3">
                    <input type="text" id="cname" name="cname" >
                    <label for="cname">
                        Customer Name:
                    </label>
                </div>
            </div>
            <div class="row">
                <div class=" input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3">
                    <input type="text" id="cphone" name="cphone" >
                    <label for="cphone">
                        Phone Number:
                    </label>
                </div>

            </div>
            <div class="row">
                <div class=" input-field col l6 m6 s6 offset-l3 offset-m3 offset-s3 teal-text remainingamount">
                    <a class="checkRemainingAmount" href="javascript:void(0)"><i class="material-icons">youtube_searched_for</i></a>  Remaining Amount: <span>0</span>

                </div>
            </div>
        </div>
        <div class="teal-text card-content">
            <button id="proceed" class="btn white-text green">Proceed</button>
        </div>
    </div>
</form>
<script>
    $(function(){
        $("#modalProceed").modal({
            complete:function(modal){
                $(modal).find('p').hide();
            }
        });
        $("#proceed").click(function(ev){
            var remainingAmount=$(".remainingamount span").text();
            if(isNaN(remainingAmount)){
                Materialize.toast('Invalid Remaining amount',3000,'red');
                return false;
            }
            if(Number(remainingAmount)>0)
                    $("#modalProceed").find('p').show();
            $("#modalProceed").modal('open');
            ev.preventDefault();
        });
        $("#proceedDone").click(function(){
            if(!localStorage.getItem('sale'))
            {
                Materialize.toast('Cart Items Not Found....!',3000,'red');
                return;
            }
            var sale=JSON.parse(localStorage.getItem('sale'));
            if(sale.cartItems.length<=0)
            {
                Materialize.toast('Cart Items Not Found....!',3000,'red');
                return;
            }
            var name=$("#cname").val();
            var phone=$("#cphone").val();
            var nameRegex=/^[a-zA-Z\s]+$/i;
            var phoneRegex=/\d{4}[\s]\d{7}/g;
            var customerid=$("#customerid").val();
            if(!name || ! name.trim()||!nameRegex.test(name))
            {
                Materialize.toast("Please enter valid customer name...!",3000,'red');
                return false;
            }
            if(!phone || !phone.trim()||!phoneRegex.test(phone))
            {
                Materialize.toast("Please enter valid phone number...!",3000,'red');
                return false;
            }
            if(sale.remaining!=0 && $("#cash").prop('checked'))
            {
                Materialize.toast("User hasn't pay full amount. Use credit Method instead",3000,'red');
                return false;
            }
            if((!customerid || !customerid.trim()) && $("#credit").prop('checked'))
            {
                Materialize.toast("Pleasem choose customer from list",3000,'red');
                return false;
            }
            $("#sale").val(localStorage.getItem('sale'));
            localStorage.removeItem('sale');
            localStorage.removeItem('cartitems');
            if(!localStorage.getItem('sale') && !localStorage.getItem('cartitems')){
             $("#fm_proceed").submit();
            }
            else console.log(localStorage.getItem('cartitems'));
        });
        $(".checkRemainingAmount").click(function(ev){
            var phone=$("#cphone").val();
            if(!phone ||  !phone.trim()){
                Materialize.toast('Please enter phone number',3000,'red');return;
            }
            $("#customerDetails").find('.remainingamount span').text(getRemainingAmount(phone))
        });

    });
    function getRemainingAmount(phone){
        var matched=false;
        $.each(customers,function(index,customer){
           if(customer.phone==phone && customer.remained>0)
           {
               matched=true;
               $("#customerDetails .remainingamount span").text(customer.remained);
               Materialize.toast('Customer has dues...!',3000,'red');
               return false;
           }
        });
        if(!matched){
            $("#customerDetails .remainingamount span").text('0');
            Materialize.toast('Customer has no dues...!',3000,'green');
        }
    }
</script>
