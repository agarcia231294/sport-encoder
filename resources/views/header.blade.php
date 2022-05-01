<nav>

    <a class="logo-container" href="{{ route('home') }}">
        <img class="logo" src="/images/logo.png" alt="LOGO">
        @lang('Sports Encoder App')
    </a>

    <div>
        @guest
        <a href="{{ route('login') }}">@lang('Login')</a> -
        <a href="{{ route('register') }}">@lang('Register')</a>
        @else
        <a href="{{ route('dashboard.home') }}">@lang('Dashboard')</a> -
        <a href="{{ route('logout') }}">@lang('Logout')</a>
        @endguest
    </div>

</nav>
