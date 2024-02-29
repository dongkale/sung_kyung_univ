<nav class="col-md-2 d-none d-md-block bg-light sidebar d-none py-4 sticky-top"> 
    <div class="sidebar-sticky list-group ">
    {{-- <div class="col-sm-2 sidenav d-none d-sm-block sidebar py-4"> --}}
        <h2><a href="{{ url('/dashboard') }}">BIBLE UNIVERSITY</a></h2>
        <ul class="nav flex-column nav-pills nav-stacked list-group">            
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/dashboard') }}" data-menu="dashboard">홈
                </a>
            </li>

            @if(Auth::user())
                @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/dashboard/memberManagement') }}" data-menu="memberManagement">사용자
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/dashboard/playManagement') }}" data-menu="playManagement">사용 목록
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/dashboard/statistics') }}" data-menu="statistics">통계
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/dashboard/setting') }}" data-menu="setting">설정
                    </a>
                </li>
                @endif
            @endif
            <!-- 다른 사이드바 메뉴 항목 추가 -->
        </ul>
    </div>
</nav>

<script>

$(document).ready( function() {    
    settingMenu();

    selectMenu("dashboard");    
} );

function settingMenu() {
    $('.list-group li').click(function(e) {
        // e.preventDefault()

        $that = $(this);

        $that.parent().find('li').removeClass('active');
        $that.addClass('active');
    });    
}

function selectMenu(select) {
    $('.list-group li').each(function(index, item) {                
        var menuName = $(this).find('a').data('menu');

        if (select == menuName) {
            $(this).find('a').addClass('active');
        } else {
            $(this).find('a').removeClass('active');
        }
        console.log(menuName);
    });
}

</script>