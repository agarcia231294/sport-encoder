<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', __('Sports Encoder App'))</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="/css/variables.css" rel="stylesheet">
        <link href="/css/global.css" rel="stylesheet">
        <link href="/css/header.css" rel="stylesheet">
        <link href="/css/footer.css" rel="stylesheet">
        @yield('style')
    </head>
    <body>
        
        @includeIf('header')

        @yield('content')

        @includeIf('footer')

        @yield('scripts')
    </body>
</html>