<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Олимпийские игры')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- навигация -->
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('olympic-games.index') }}">
                <img src="https://i.pinimg.com/originals/48/fd/11/48fd1107bbfe1d4d43feac8a542aa124.jpg?nii=t" alt="Лого" width="40" height="40" class="rounded me-2">
                Олимпийские игры
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Меню">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('olympic-games.index') ? 'active' : '' }}" href="{{ route('olympic-games.index') }}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('olympic-games.create') }}">Добавить</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contacts">Контакты</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- основной контент -->
    <main class="container main-content flex-grow-1" id="games">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fa-solid fa-spinner loading-icon text-primary me-2"></i>
                <strong class="me-auto">Загрузка</strong>
                <small class="text-muted me-2" id="toastYear"></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
            </div>
            <div class="toast-body">На текущий момент этот функционал недоступен.</div>
        </div>
    </div>

    <!-- низ -->
    <footer class="bg-white border-top mt-5 py-4" id="contacts">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
            <span class="text-muted">Яковленко Анастасия Алексеевна</span>
            <div class="social-links d-flex gap-3">
                <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
