@extends('layouts.app')

@section('title', '메인 대시보드')

@section('content')

<div class="d-flex col-md-12 justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">대시보드</h1>
    <!-- 다른 컨텐츠 상단에 추가할 수 있는 요소들 --> 
    <div class="row">        
        @guest
            @if (Route::has('login'))
            <div class="mr-3">
                <a href="{{ route('login') }}">{{ __('로그인') }}</a>
            </div>
            @endif

            @if (Route::has('register'))
            <div class="mr-3">
                <a href="{{ route('register') }}">{{ __('가입') }}</a>                
            </div>
            @endif
        @else    
           <div class="dropdown">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                    {{ Auth::user()->name }}
                </button>

                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        {{ __('로그아웃') }}
                    </a>
                </div>        

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                   @csrf
                </form>                
            </div>
        @endguest        
     </div>     


     {{-- <div class="dropdown">
        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
            이동관
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#">로그아웃</a>            
        </div>
    </div> --}}

    {{-- <ul class="ms-auto">
        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif

            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
        </ul> 
    </div> --}}
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