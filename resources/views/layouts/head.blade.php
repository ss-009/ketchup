<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title') | 音楽制作者のためのQ&Aサイト</title>
	<meta content="@yield('description')" name="description">

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}" defer></script>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/common.css') }}" rel="stylesheet">
	@yield('pageCss')
	
</head>
<body>
	<div>
		<nav id="header">
			<div class="navbar-light bg-ketchup">
				<div class="header-container text-center mx-3">
					<div class="header-start d-inline-block">
						<a class="navbar-brand" href="{{ url('/') }}">
							<img src="{{ asset('img/common/ketchupHeader.png') }}" alt="Ketchup">
						</a>
						<div class="search_container d-inline-block align-middle">
							<form method="get" name="search_question" action="/search">
								<input type="text" name="q" class="rounded align-top" size="25" @isset($keyword) value="{{$keyword}}" @endisset placeholder="キーワード検索" autofocus>
								<a href="javascript:search_question.submit()"><img src="{{ asset('img/common/search.svg') }}" alt="検索" id="search"></a>
							</form>
						</div>
					</div>

					<div class="header-end d-inline-block">
						<ul>
							<li class="header-end-li">
								<a class="header-link" href="/question" id="question">
									<img src="{{ asset('img/common/question.svg') }}" id="svg_question" class="svg-question">
									<span>質問する</span>
								</a>
							</li>
							@guest
								<li class="header-end-li">
									<a class="header-link" href="{{ route('login') }}" id="login">
										<img src="{{ asset('img/common/login.svg') }}" id="svg_login" class="svg-login">
										<span>ログイン</span>
									</a>
								</li>
								@if (Route::has('register'))
									<li class="header-end-li">
										<a class="header-link" href="{{ route('register') }}" id="register">
											<img src="{{ asset('img/common/register.svg') }}" id="svg_register" class="svg-register">
											<span>新規登録</span>
										</a>
									</li>
								@endif
							@else
								<li class="header-end-li">
									<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
										{{ Auth::user()->user_id }} <span class="caret"></span>
									</a>

									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
										<a class="dropdown-item" href="{{ route('logout') }}"
										onclick="event.preventDefault();
														document.getElementById('logout-form').submit();">
											{{ __('Logout') }}
										</a>

										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
											@csrf
										</form>
									</div>
								</li>
							@endguest
						</ul>
					</div>
				</div>
			</div>
		</nav>

