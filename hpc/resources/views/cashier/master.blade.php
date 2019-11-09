<html>
<head>
    <link href="{{asset('materializecss/css/materialize.min.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('js/jquery-3.2.1.js')}}"></script>
    <script type="text/javascript" src="{{asset('materializecss/js/materialize.min.js')}}"></script>
    <script language="JavaScript" type="text/javascript" src="{{asset('js/jquery.cookie.min.js')}}"></script>

</head>
<body>
@include('cashier.navbar')
<div class="row">
    <div class="col l12 m12 s12">
        @yield('cashier_content')
    </div>
</div>
</body>
</html>