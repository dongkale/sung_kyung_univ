<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '대시보드')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- 부트스트랩 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- 부트스트랩 JS 및 기타 스크립트 -->
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .row.content {height: 550px}
        .sidebar {
            background-color: #f1f1f1;
            height: 100%;
            min-height: 100vh; /* 최소 높이를 화면의 전체 높이로 설정 */
        }
        @media screen and (max-width: 767px) {
            .row.content {height: auto;} 
        }
        .card {
            margin-bottom: 20px;
            padding: 15px;
            /* padding-left: 15px;
            padding-right: 15px; */
        }
        /* 버튼 스타일 */
        .btn-primary {
            background-color: #007bff; /* 파란색 */
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3; /* 파란색 (hover 시) */
            border-color: #0056b3;
        }            
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            @include('partials.sidebar')
            {{-- <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4"> --}}
            <main role="main" class="col-md-8 px-md-4">
                @include('partials.main_top')
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>