<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ __('views.layout.title') }}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body class="min-vh-100 d-flex flex-column">
        <header class="flex-shrink-0">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <a class="navbar-brand" href="{{ route('welcome') }}">{{ __('views.layout.title') }}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('welcome')) active @endif" href="{{ route('welcome') }}">{{ __('views.layout.home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('urls.index')) active @endif" href="{{ route('urls.index') }}">{{ __('views.layout.sites') }}</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <main class="flex-grow-1">
            @include('flash::message')
            @yield('content')
        </main>
        <footer class="border-top py-3 mt-5 flex-shrink-0">
            <div class="container-lg">
                <div class="text-center">
                    <a href="https://hexlet.io/pages/about" target="_blank">{{ __('views.layout.company') }}</a>
                </div>
            </div>
        </footer>
    </body>
</html>
