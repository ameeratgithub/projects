@php
    $hasMessage=\Illuminate\Support\Facades\Session::has('message');
    $type=\Illuminate\Support\Facades\Session::get('type');
@endphp
@if($hasMessage)
    <script>
        Materialize.toast("{{\Illuminate\Support\Facades\Session::get('message')}}",5000,"{{$type==='info'?'teal':'red'}}")
    </script>
@endif