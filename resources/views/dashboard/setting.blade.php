@extends('layouts.app')

@section('title', '메인 대시보드')

@section('content')


<script>

$(document).ready( function() {    
    var menu = "{{$menu}}";

    selectMenu(menu);
} );

</script>

@endsection