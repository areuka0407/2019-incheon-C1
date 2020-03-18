<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="벡스코">
    <meta property="og:description" content="벡스코 행사 일정을 한 눈에 알아보거나 행사장을 간편히 예약할 수 있습니다!">
    <meta property="og:image" content="/images/open-graph.png">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <title>Bexco | 벡스코</title>
    <!-- css -->
    <link rel="stylesheet" href="/jquery-ui-1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="/css/layout.css">
    <link rel="stylesheet" href="/css/style.css">
    <!-- /css -->
    <!-- js -->
    <script src="/js/jquery-3.4.1.js"></script>
    <script src="/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <script src="/js/common.js"></script>
    <script src="/js/index.js"></script>
    <!-- /js -->
</head>
<body>
    <!-- HEADER -->
    <header id="header">
        <div class="container d-flex justify-content-between align-items-center h-100">
            <a href="/" class="logo border-sm-none">
                <img src="/images/Vlogo.png" alt="벡스코" height="180">
            </a>
            <nav id="nav" class="d-sm-none fx-n1">
                <div class="nav-item"><a href="/">BEXCO</a></div>
                <div class="nav-item"><a href="/reservation/placement">행사장 임대</a></div>
                <div class="nav-item"><a href="/reservation/transportation">교통편 예약</a></div>
                <div class="nav-item"><a href="/admin/venue">관리자 접속</a></div>
            </nav>
            <div class="other fx-n2 d-sm-none">
                <a id="link-login" href="#" class="px-2">로그인</a>
                <a id="link-join" href="#" class="px-2 ml-3">회원가입</a>
            </div>
            
            <!-- MOBILE NAV -->
            <form class="d-none d-sm-block">
                <input type="checkbox" id="nav-open" hidden>
                <label for="nav-open" class="mr-3 icon d-none d-sm-block fx-3 position-relative">
                    <img src="/images/icons/menu.png" alt="메뉴">
                </label>
                <div id="m-nav">
                    <div class="m-nav-inner">
                        <nav class="nav">
                            <div class="nav-item hover-opacity"><a href="/">BEXCO</a></div>
                            <div class="nav-item hover-opacity"><a href="/reservation/placement">행사장 임대</a></div>
                            <div class="nav-item hover-opacity"><a href="/reservation/transportation">교통편 예약</a></div>
                            <div class="nav-item hover-opacity"><a href="/admin/venue">관리자 접속</a></div>
                        </nav>
                        <div class="other fx-n2 mt-4 fx-2">
                            <a href="#" class="px-2 hover-opacity">로그인</a>
                            <a href="#" class="px-2 hover-opacity ml-3">회원가입</a>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /MOBILE NAV -->
        </div>
    </header>
    <!-- /HEADER -->