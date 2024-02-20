@extends('layouts.app')

@section('title', '메인 대시보드')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">대시보드</h1>
    <!-- 다른 컨텐츠 상단에 추가할 수 있는 요소들 -->
</div>

<!-- 대시보드 컨텐츠 -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div>Some text here</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div>Some text here</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div>Some text here</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div>Some text here</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <div class="card">
            <div>Some text here</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div>Some text here</div>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                카드 1
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                카드 2
            </div>
        </div>
    </div>
    <!-- 추가적인 대시보드 카드 -->
</div> --}}

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Primary card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Primary card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </div>
</div>

 <script>

$(document).ready( function() {
    var menu = "{{$menu}}";

    console.log(`menu: ${menu}`);
} );

// function settingMenu() {
//     $('.list-group li').click(function(e) {
//         // e.preventDefault()

//         $that = $(this);

//         $that.parent().find('li').removeClass('active');
//         $that.addClass('active');
//     });    
// }

// function selectMenu(select) {
//     $('.list-group li').each(function(index, item) {                
//         var menuName = $(this).find('a').data('menu');

//         if (select == menuName) {
//             $(this).find('a').addClass('active');
//         } else {
//             $(this).find('a').removeClass('active');
//         }
//         console.log(menuName);
//     });
// }

</script>

@endsection