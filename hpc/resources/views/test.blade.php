<html>
<head>
<link href="{{asset('materializecss/css/materialize.min.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-3.2.1.js')}}" ></script>
    <script src="{{asset('materializecss/js/materialize.min.js')}}" ></script>

    <style>

    </style>
    <script>
        $(function () {
           $(".datepicker").pickadate({
               closeOnSelect:false
           });
        });
    </script>
</head>
<body>
<form action="/disabled" method="post">
{{csrf_field()}}
    <div class="input-field">
        <input type="text" value="Value of disabaled" name="disabled" disabled/>
    </div>
    <input type="submit" value="Submit"/>
</form>
</body>
</html>