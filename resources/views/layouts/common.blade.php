<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Ketchup') }} | 音楽制作者のためのQ&Aサイト</title>
	<meta content="Ketchupは音楽制作者のためのQ&Aサイトです。 作詞・作曲から編曲・DAW操作までDTMや曲作りに関する悩みを解決しましょう。" name="description">
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/common.css') }}" rel="stylesheet">
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
	
</head>
<body>
	<header id="header">
		<div class="navbar-light bg-ketchup">
			<div class="header-container text-center mx-3">
				<div class="header-start d-inline-block">
					<a class="navbar-brand" href="{{ url('/') }}">
						<img src="{{ asset('img/common/ketchupHeader.png') }}" alt="Ketchup">
					</a>
					<div class="search_container d-inline-block align-middle">
						<input type="text" class="rounded align-top" size="25" placeholder="キーワード検索" autofocus>
						<a href="javascript:void(0)"><img src="{{ asset('img/common/search.svg') }}" alt="検索" id="search"></a>
					</div>
				</div>

				<div class="header-end d-inline-block">
					<ul>
						<li class="header-end-li">
							<a class="header-link" href="javascript:void(0)" id="question">
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
	</header>
	<div class="header-bottom">
		<div class="header-bottom-container text-center">
			<div class="header-bottom-start d-inline-block align-middle">
				<img src="{{ asset('img/common/ketchupTop.png') }}" alt="音楽制作者のためのQ&Aサイト" id="top_ketchup" class="top-ketchup">
				<div class="slogan-div">
					<p class="slogan-p">聞いて、教えて、うまくなる。<img src="{{ asset('img/common/balloon.png') }}" id="top_balloon" class="top-balloon"></p>
					<p>DTM、曲作りについて悩んだら質問しましょう！</p>
				</div>
			</div>

			<div class="header-bottom-end d-inline-block align-middle">
				<div class="top-user">
					<div class="top-user-register">
						<p>ユーザーID</p>
						<input id="user_id" name="user_id" type="text" class="rounded @error('user_id') is-invalid @enderror" value="{{ old('user_id') }}" placeholder="ketchup" required autocomplete="user_id">
						@error('user_id')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="top-user-register">
						<p>メールアドレス</p>
						<input id="email" name="email" type="text" class="rounded @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="info@ketchup-music.com" required autocomplete="email">
						@error('email')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="top-user-register">
						<p>パスワード (英数字記号8文字以上)</p>
						<input id="password" name="password" type="password" class="rounded @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="********" required autocomplete="current-password">
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
				</div>
				<div class="text-center pt-1">
					<a class="top-user-register-sign-up" href="javascript:void(0)" id="top_register">登録する</a>
				</div>
				<div class="sns-register mt-5">
					<div class="sns-auth bg-light d-inline-block">
						<a href="javascript:void(0)" class="sns-auth-span">
							<img src="{{ asset('img/common/google.png') }}" id="google_auth" class="sns-register">
							<span>Google</span>
						</a>
					</div>
					<div class="sns-auth bg-light d-inline-block">
						<a href="javascript:void(0)" class="sns-auth-span">
							<img src="{{ asset('img/common/facebook.png') }}" id="google_auth" class="sns-register">
							<span>Facebook</span>
						</a>
					</div>
					<div class="sns-auth bg-light d-inline-block">
						<a href="javascript:void(0)" class="sns-auth-span">
							<img src="{{ asset('img/common/twitter.png') }}" id="google_auth" class="sns-register">
							<span>Twitter</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<main>
		@yield('content')
	</main>

	<footer>
		<div class="ketchup-footer">
			<ul class="footer-ul">
				<li class="footer-li"><a href="#"><i class="fas fa-chevron-circle-right"></i>利用規約</a></li>
				<li class="footer-li"><a href="#"><i class="fas fa-chevron-circle-right"></i>ガイドライン</a></li>
				<li class="footer-li"><a href="#"><i class="fas fa-chevron-circle-right"></i>プライバシーポリシー</a></li>
				<li class="footer-li"><small>&copy; 2019-2020</span> ketchup-music.com.</small></li>
		</div>
	</footer>
</body>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}" defer></script>
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/common.js') }}" defer></script>
</html>
