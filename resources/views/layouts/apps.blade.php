<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <!-- Page title -->
    <title>{{config('global.siteTitle')}}</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" type="image/ico" href="{{config('global.baseURL')}}/public/favicon.ico" />

    <!-- Vendor styles -->
    {!!HTML::style('public/admintheme/vendor/fontawesome/css/font-awesome.css')!!}
    {!!HTML::style('public/admintheme/vendor/metisMenu/dist/metisMenu.css')!!}
    {!!HTML::style('public/admintheme/vendor/animate.css/animate.css')!!}
    {!!HTML::style('public/admintheme/vendor/bootstrap/dist/css/bootstrap.css')!!}

    <!-- App styles -->
    {!!HTML::style('public/admintheme/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css')!!}
    {!!HTML::style('public/admintheme/fonts/pe-icon-7-stroke/css/helper.css')!!}
    {!!HTML::style('public/admintheme/styles/style.css')!!}
  
    @stack('css')

</head>
<body>

<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>{{config('global.siteTitle')}}</h1>
{!! HTML::image('public/admintheme/images/loading-bars.svg', 'Loading...', array('width'=>'64', 'height'=>'64')) !!}
 </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Header -->
<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            <a href="{{URL::to('/')}}">
                {!!HTML::image(config('global.siteImages')."logo.jpg", 'Loading...', array('width'=>'100', 'height'=>'30'))!!}
            {{-- {!!HTML::image(config('global.baseURL').'/favicon.ico', 'alt', array('width'=>'30', 'height'=>'30'))!!} --}}
            </a>
        </span>
        {{-- <span>
            {{config('global.siteTitle')}}
        </span> --}}
        
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary">{{config('global.siteTitle')}}</span>
            <span>
                {!!HTML::image(config('global.baseURL').'/favicon.ico', 'alt', array('width'=>'30', 'height'=>'30'))!!}
            </span>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <li class="dropdown">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> <i class="pe-7s-upload pe-rotate-90"></i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</div>

<!-- Navigation -->
@include('layouts.sidebar')


<!-- Main Wrapper -->
<div id="wrapper">

    @yield('content')
    <!-- Footer-->
    <footer class="footer">
        <span class="pull-right">
            Powered by {!!HTML::link(config('global.appWebPage'),config('global.companyName'), array('target'=>'_blank'))!!}
        </span>
        {{config('global.siteTitle')}} @ {{config('global.currentYear')}}
    </footer>

</div>

<!-- Vendor scripts -->
{!!HTML::script('public/admintheme/vendor/jquery/dist/jquery.min.js')!!}
{!!HTML::script('public/admintheme/vendor/jquery-ui/jquery-ui.min.js')!!}
{!!HTML::script('public/admintheme/vendor/slimScroll/jquery.slimscroll.min.js')!!}
{!!HTML::script('public/admintheme/vendor/bootstrap/dist/js/bootstrap.min.js')!!}
{!!HTML::script('public/admintheme/vendor/jquery-flot/jquery.flot.js')!!}
{!!HTML::script('public/admintheme/vendor/jquery-flot/jquery.flot.resize.js')!!}
{!!HTML::script('public/admintheme/vendor/jquery-flot/jquery.flot.pie.js')!!}
{!!HTML::script('public/admintheme/vendor/flot.curvedlines/curvedLines.js')!!}
{!!HTML::script('public/admintheme/vendor/jquery.flot.spline/index.js')!!}
{!!HTML::script('public/admintheme/vendor/metisMenu/dist/metisMenu.min.js')!!}
{!!HTML::script('public/admintheme/vendor/iCheck/icheck.min.js')!!}
{!!HTML::script('public/admintheme/vendor/peity/jquery.peity.min.js')!!}
{!!HTML::script('public/admintheme/vendor/sparkline/index.js')!!}
{!!HTML::script('public/plugins/bootbox.min.js')!!}
{!!HTML::script('public/admintheme/vendor/nestable/jquery.nestable.js')!!}

<!-- App scripts -->
{!!HTML::script('public/admintheme/scripts/homer.js')!!}
{!!HTML::script('public/admintheme/scripts/charts.js')!!}
@stack('scripts')
</body>
</html>