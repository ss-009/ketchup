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