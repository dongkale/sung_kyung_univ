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