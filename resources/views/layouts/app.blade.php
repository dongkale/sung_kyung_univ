<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '대시보드')</title>
    
    <!-- 부트스트랩 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- 부트스트랩 JS 및 기타 스크립트 -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        @include('partials.sidebar')
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>