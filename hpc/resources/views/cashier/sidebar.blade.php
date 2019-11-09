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
        background-color: #18f0ff;
    }
    .hpc-sidenav .user-actions .card-content ul li:hover a i.material-icons{
    }
    .hpc-sidenav .user-actions .card-content ul li:hover a,.hpc-sidenav .user-actions .card-content ul li:hover{
        color:white !important;
    }
</style>
<div class="hpc-sidenav">
    <div class="card user-info">
        <img src="{{asset('images/bg-23.jpg')}}"/>
        <span class="user-name white-text">John Doe</span>
        <span class="user-email white-text">johndoe@gmail.com</span>
    </div>
    <div class="card user-actions">
        <div class="card-content">
            <ul>
                <li><i class="material-icons" >home</i><a href="/admin" class="teal-text">Home</a></li>
                <li><i class="material-icons">supervisor_account</i><a href="/cart" class="teal-text">Cart <span class="teal lighten-3 new badge" data-badge-caption="">3</span></a></li>
            </ul>
        </div>
    </div>
</div>