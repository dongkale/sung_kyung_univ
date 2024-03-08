<nav class="col-md-2 d-none d-sm-block bg-light sidebar py-4 sticky-top"> 
    <div class="sidebar-sticky list-group ">
        <h2><a href="{{ url('/dashboard') }}" style="text-decoration: none">BIBLE UNIVERSITY</a></h2>
        <ul class="nav flex-column nav-stacked list-group mt-3">            
            <li class="nav-item">
                <div class="d-flex align-items-center">
                    <span class="fa fa-bars mr-1 ml-2"></span>
                    <a class="nav-link" href="{{ url('/dashboard') }}" data-menu="dashboard">홈</a>                                
                </div>
            </li>

            @if(Auth::user())
                @if (Route::has('login'))
                <li class="nav-item">
                    <div class="d-flex align-items-center">
                        <span class="fa fa-bars mr-1 ml-2"></span>
                        <a class="nav-link" href="{{ url('/dashboard/memberManagement') }}" data-menu="memberManagement">사용자</a>                    
                    </div>
                </li>
                <li class="nav-item">
                    <div class="d-flex align-items-center">
                        <span class="fa fa-bars mr-1 ml-2"></span>
                        <a class="nav-link" href="{{ url('/dashboard/playManagement') }}" data-menu="playManagement">사용 목록</a>                    
                    </div>
                </li>
                <li class="nav-item">
                    <div class="d-flex align-items-center">
                        <span class="fa fa-bars mr-1 ml-2"></span>
                        <a class="nav-link" href="{{ url('/dashboard/statistics') }}" data-menu="statistics">통계</a>                    
                    </div>
                </li>
                <li class="nav-item">
                    <div class="d-flex align-items-center">
                        <span class="fa fa-bars mr-1 ml-2"></span>
                        <a class="nav-link" href="{{ url('/dashboard/setting') }}" data-menu="setting">설정</a>                    
                    </div>
                </li>
                @endif
            @endif
            <!-- 다른 사이드바 메뉴 항목 추가 -->

            {{--  --}}
            <li class="nav-item" style="display: none">
                <a class="nav-link top-menu" href="#menu1-collapse" aria-expanded="{{( $mainMenu == 'MENU_1' ) ? 'true' : 'false'}}" data-toggle="collapse">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        {{-- <i class="fa fa-bars"></i>&nbsp;메뉴 1 <i class="fa fa-angle-down pull-right ml-auto submenu-icon"></i> --}}
                        <span class="fa fa-bars"></span>
                        <span class="menu-collapsed">&nbsp;메뉴 1</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <div>
                    <ul id="menu1-collapse" class="list-unstyled collapse ml-3 {{ ($mainMenu ==  'MENU_1') ? 'show' : '' }}">
                        <li class="nav-menu-hover {{ ($subMenu == 'MENU_1_A') ? 'active' : '' }}">
                            <a class="nav-menu" href="{{ url('/menu_1_a') }}">&nbsp;메뉴 1-1</a>
                        </li>
                        <li class="nav-menu-hover {{ ($subMenu == 'MENU_1_B') ? 'active' : '' }}">
                            <a class="nav-menu " href="{{ url('/menu_1_b') }}">&nbsp;메뉴 1-2</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" style="display: none">
                <a class="nav-link top-menu" href="#menu2-collapse" aria-expanded="{{( $mainMenu == 'MENU_2' ) ? 'true' : 'false'}}" data-toggle="collapse">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        {{-- <i class="fa fa-bars"></i>&nbsp;메뉴 2 <i class="fa fa-angle-down pull-right ml-auto submenu-icon"></i> --}}
                        <span class="fa fa-bars"></span>
                        <span class="menu-collapsed">&nbsp;메뉴 2</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <div>
                    <ul id="menu2-collapse" class="list-unstyled collapse ml-3 {{ ($mainMenu ==  'MENU_2') ? 'show' : '' }}">
                        <li class="nav-menu-hover {{ ($subMenu == 'MENU_2_A') ? 'active' : '' }}">
                            <a class="nav-menu " href="{{ url('/menu_2_a') }}">&nbsp;메뉴 2-1</a>
                        </li>
                        <li class="nav-menu-hover {{ ($subMenu == 'MENU_2_B') ? 'active' : '' }}">
                            <a class="nav-menu " href="{{ url('/menu_2_b') }}">&nbsp;메뉴 2-2</a>
                        </li>
                    </ul>
                </div>
            </li>
            
            {{-- <li class="nav-item sidebar-dropdown">                    
                <a class="nav-link" href="#menu2-collapse" data-toggle="collapse">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <i class="fa fa-bars"></i> 메뉴2 <i class="fa fa-angle-down pull-right ml-auto"></i>
                    </div>
                </a>                
                <ul id="menu2-collapse" class="list-unstyled collapse ml-3">
                    <li class="ml-2">
                        <a href="#menu1_1"> <i class="fa fa-angle-right"></i> 메뉴1 </a>
                    </li>
                    <li class="ml-2">>
                        <a href="#menu1_2"> <i class="fa fa-angle-right"></i> 메뉴2 </a>
                    </li>
                </ul>
            </li> --}}
            {{--  --}}
            {{-- <div id="sidebarMenu" class="sidebar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu1-collapse" aria-expanded="false">
                            <i class="fa fa-bars"></i> 메뉴1 <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <div id="menu1-collapse" class="collapse" aria-labelledby="headingOne" data-parent="#sidebarMenu">
                            <ul class="list-unstyled">
                                <li><a href="#menu1_1">메뉴1</a></li>
                                <li><a href="#menu1_2">메뉴2</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu2-collapse" aria-expanded="false">
                            <i class="fa fa-bars"></i> 메뉴2 <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <div id="menu2-collapse" class="collapse" aria-labelledby="headingTwo" data-parent="#sidebarMenu">
                            <ul class="list-unstyled">
                                <li><a href="#menu2_1">메뉴1</a></li>
                                <li><a href="#menu2_2">메뉴2</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div> --}}
            {{--  --}}
        </ul>
    </div>
</nav>

<script>

$(document).ready( function() {    
    settingMenu();
    
    selectMenu();
} );

function settingMenu() {
    $('.list-group li').click(function(e) {
        // e.preventDefault()

        $that = $(this);

        $that.parent().find('li').removeClass('active');
        $that.addClass('active');
    });    
}

function selectMenu() {
    var url = window.location.href;
    var activePage = url;

    $('.list-group li').each(function () {        
        var findit = $(this).find('a'); // $(this).find('ul li a');

        var linkPage = findit.attr('href');
        
        if (activePage == linkPage) {            
            // findit.closest('.collapse').addClass('show'); // 부모 collapse 항목 펼치기
            // findit.closest('.collapse').collapse('show');
            
            //findit.closest('.collapse').collapse('show');
            findit.parent().addClass('active');
            findit.addClass('active');

            console.log(`activePage ==> ${linkPage}`);
            // findit.parent().addClass('active');
        } else {            
            findit.parent().removeClass('active');
            findit.removeClass('active');
            // findit.parent().collapse('hide');

            // findit.parent().removeClass('active');
            // findit.parent().collapse('hide');            
        }
    });
}

// 서브메뉴 펼쳐질때 부드럽게 펼쳐지도록 설정
$('.collapse').on('show.bs.collapse', function() {
    $(this).slideDown(200);
    console.log(`show`);
    // $('.collapse').not($(this)).collapse('hide');
}).on('hide.bs.collapse', function() {
    $(this).slideUp(200);
    console.log(`hide`);    
});

// 선택된 메뉴만 펼쳐기
$('a.top-menu').click(function () {        
    $('.collapse').not($(this)).collapse('hide');
});


/*
$('a.top-menu').click(function () {    
    var that = $(this);

    console.log(`Active: ${that.prop("href")}`);

    $('a.top-menu').not(that).each(function(){
         var that = $(this);
         console.log(`Inactive: ${that.prop("href")}`);       
    });

    $('.collapse').not($(this)).collapse('hide');

    // $('.collapse').not($(this)).each(function(){
    //      var that = $(this);
    //      console.log(`Inactive: ${that.prop("href")}`);       
    // });
});
*/


</script>