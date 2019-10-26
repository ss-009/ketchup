<DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@yield('head')
</head>
<body>
@yield('header')
<div>
	<div class="main">
		@yield('content')
	</div>
	<div class="sub">
		@yield('sub')
		@yield('pageSub')
	</div>
</div>
@yield('footer')
</body>
</html>