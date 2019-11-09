<html>
<head>
    <meta name="csrf_token" content="{{csrf_token()}}"/>
<link href="{{asset('materializecss/css/materialize.min.css')}}" rel="stylesheet">
    <script language="JavaScript" type="text/javascript" src="{{asset('js/jquery-3.2.1.js')}}"></script>

    <script language="JavaScript" type="text/javascript" src="{{asset('materializecss/js/materialize.min.js')}}"></script>
    <script>
        $(function(){
            $('select').material_select();
        });
    </script>
    <style>
        table tr td{
            color: #1d7d74;
        }
    </style>
</head>
<body>
@include('admin.layout.navbar')
<div class="row">
    <div class="col l2 m2 s2" style="padding: 0;">
        @include('admin.layout.sidebar')
    </div>
    <div class="col l10 m10 s10">
        <br/><br/>
        @yield('admin_content')
    </div>
</div>
<script>
    $(function (ev) {

        $('.modal').modal({
            ready:function(modal,trigger){
                var linkaction=$(trigger).data('linkaction');
                if((linkaction && linkaction.trim()) && (linkaction=="reset" || linkaction=="delete")){
                    var entityid=$(trigger).data('entityid');
                    if(entityid)
                    {
                        $(modal).find('form .entityid').val(entityid);
                    }
                }
            },
            complete:function(){
                if(!$(this).hasClass('keepData')){
                    $(this).find('form').find('input').val('');
                    $(this).find('form').find('select').material_select();
                }
            }
        });
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year,
            today: 'Today',
            clear: 'Clear',
            close: 'Ok',
            closeOnSelect: true
        });
    });
</script>
@yield('page_script')
</body>
</html>