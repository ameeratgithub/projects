<style>
    .filtercustomer{
        margin-top: -1%;
    }
    .filtercustomer .card{
        margin: 0;
    }
    .filtercustomer .card.back{
        z-index: -1;
    }
    .filtercustomer .card:nth-child(2) .card-content{
        padding-top: 0;
    }
    .filtercustomer .card:nth-child(2) .card-content .input-field {
        padding: 0;
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
<input type="hidden" id="customers" value="{{$customers}}">
<div class="filtercustomer">
    <div class="card cyan lighten-1 white-text back">
        <div class="card-content">
            <span class="card-title center-align">Customer</span>
        </div>
    </div>
    <div class="card blue lighten-5 teal-text actions">
        <div class="card-content">
            <br/>
            <div class="row">
                <div class="input-field input-field  col l12 m12 s12">
                    <input type="text" id="customer" name="customer" disabled>
                    <label for="customer">
                        Customer Name or Phone:
                    </label>
                </div>
            </div>
        </div>
        <div class="row" id="customerlist">
            <div class="col s12 m12 l12">
                <ul class="collection">
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    var customers=[];
    $(function(){
        customers=JSON.parse($('#customers').val());
        /*displayAllCustomers();*/
        $("#customer").keyup(function(){
            $("#customerlist").find('.collection').empty();
            var value=$(this).val();
            var filteredCustomers=[];
            if(!value || !value.trim()){
                displayAllCustomers();
                return;
            }
            $.each(customers,function(index,customer){
                var cn=customer.name.toLowerCase();
                var pn=customer.phone;
                var nameExists=cn.indexOf(value.toLowerCase())>-1;
                var phoneExists=pn.indexOf(value.toLowerCase())>-1;
                if(nameExists || phoneExists)
                {
                    filteredCustomers.push(customer);
                }
            });
            renderItems(filteredCustomers);
        });
    });
    function getItem(customer){
        var li=$('<li/>').addClass('collection-item').data('customer',customer).click(function(ev){
            var customer=$(this).data('customer');
            $("#cphone").val(customer.phone).siblings('label').addClass('active');
            $("#cname").val(customer.name).siblings('label').addClass('active');
            $("#customerid").val(customer.id);
        });
        var div=$('<div/>').text(customer.name +" ("+customer.phone+")");
        li.append(div);
        return li;
    }
    function renderItems(customers){
        if(customers.length>0)
            $.each(customers,function(index,customer){
                $("#customerlist").find('.collection').append(getItem(customer));
            });
    }
    function removeCustomers(){
        $("#customerlist").find('.collection').empty();
    }
    function disableCustomers(){
        removeCustomers();
        $("#customer").val('').prop('disabled',true);
    }
    function displayAllCustomers(){
        removeCustomers();
        $("#customer").prop('disabled',false);
        renderItems(customers);
    }
</script>