<header class="header">
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
											{{ __('登録情報を編集') }}
										</a>
										<a class="dropdown-item" href="{{ route('logout') }}"
										onclick="event.preventDefault();
														document.getElementById('logout-form').submit();">
											{{ __('ログアウト') }}
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