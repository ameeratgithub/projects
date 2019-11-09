<style>
    span.new.badge{
        border-radius: 100%;
    }
    .hpc-sidenav .card{
        margin: 0;border-radius: 0;
    }
    .hpc-sidenav .user-info{
        z-index: -1;
    }
    .hpc-sidenav .user-info img{
        width: 100%;height: 20%;
    }
    .hpc-sidenav .user-info .user-name{
        position: absolute;margin: -25% 0 0 10%;font-size: large; font-weight: 900;{}
    }
    .hpc-sidenav .user-info .user-email{
        position: absolute;margin: -15% 0 0 10%; font-weight: 400;
    }
    .hpc-sidenav .user-actions .card-content{
        padding-left: 0; padding-right: 0px;height: 70%; overflow-y: auto;
    }
    .hpc-sidenav .user-actions .card-content ul li{
        padding: 8px 8px 8px 40px;
    }
    .hpc-sidenav .user-actions .card-content ul li  i{
        font-size: medium;font-weight: bold;margin-right: 5%;margin-top: 1.5%;
    }

    .hpc-sidenav .user-actions .card-content ul li:hover{
        background-color: rgba(99, 92, 148, 0.89);
    }
    .hpc-sidenav .user-actions .card-content ul li:hover a,.hpc-sidenav .user-actions .card-content ul li:hover{
        color:white !important;
    }
</style>
<div class="hpc-sidenav">
    <div class="card user-info">
        <img src="{{asset('images/bg-23.jpg')}}"/>
        <span class="user-name white-text">{{ \Illuminate\Support\Facades\Auth::user()->name}}</span>
        <span class="user-email white-text">{{ \Illuminate\Support\Facades\Auth::user()->email}}</span>
    </div>
    <div class="card user-actions">
        <div class="card-content">
            <ul>
                <li><i class="material-icons" >home</i><a href="/admin" class="teal-text">Home</a></li>
                <li><i class="material-icons">perm_identity</i><a href="/users" class="teal-text">Users </a><span class="teal lighten-3 new badge" data-badge-caption="">{{$tusers-1}}</span></li>
                <li><i class="material-icons">account_balance</i><a href="/repositories" class="teal-text">Repositories </a> <span class="teal lighten-3 new badge" data-badge-caption="">{{$trepositories}}</span></li>
                <li><i class="material-icons">business_center</i><a href="/companies" class="teal-text">Companies </a><span class="teal lighten-3 new badge" data-badge-caption="">{{$tcompanies}}</span></li>
                <li><i class="material-icons">shopping_cart</i><a href="/products" class="teal-text">Products </a> <span class="teal lighten-3 new badge" data-badge-caption="">{{$tproducts}}</span></li>
                <li><i class="material-icons">equalizer</i><a href="/stockin" class="teal-text">Stockin </a> <span class="teal lighten-3 new badge" data-badge-caption="">{{$tstockin}}</span></li>
                <li><i class="material-icons">supervisor_account</i><a href="/customers" class="teal-text">Customers </a> <span class="teal lighten-3 new badge" data-badge-caption="">{{$tcustomers}}</span></li>
                <li><i class="material-icons">attach_money</i><a href="/payments" class="teal-text">Payments </a> <span class="teal lighten-3 new badge" data-badge-caption="">{{$tpayments}}</span></li>
                <li><i class="material-icons">history</i><a href="/biltihistory" class="teal-text">Bilti History</a><span class="teal lighten-3 new badge" data-badge-caption="">{{$tbiltihistory}}</span></li>
            </ul>
        </div>
    </div>
</div>