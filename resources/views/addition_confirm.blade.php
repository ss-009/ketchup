@section('title', 'Ketchup')
@section('description', 'Ketchupは音楽制作者のためのQ&Aサイトです。 作詞・作曲から編曲・DAW操作までDTMや曲作りに関する悩みを解決しましょう。')

@section('pageCss')
<link href="{{ asset('css/common.css') }}" rel="stylesheet">
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
<link href="{{ asset('css/question_detail.css') }}" rel="stylesheet">
<link href="{{ asset('css/question.css') }}" rel="stylesheet">
@endsection

@include('layouts.head')

<div class="card">
	<div class="content-confirm">
		<div class="content-header">{{ __('補足内容確認画面') }}</div>
		<form method="POST" action="complete">
			@csrf

			<div class="question-area">
				<div class="question_title">
					<h1>{{$question_title}}</h1>
				</div>
				<div class="top-question-inner d-inline-block">
					<div class="top-question-tag">
						<ul class="question-tag-ul">
							<li class="question-tag-li">
								<a href="{{$tag_id_1}}">{{$tag_name_1}}</a>
							</li>
							@if ($tag_id_2 !== 0)
							<li class="question-tag-li">
								<a href="{{$tag_id_2}}">{{$tag_name_2}}</a>
							</li>
							@endif
							@if ($tag_id_3 !== 0)
							<li class="question-tag-li">
								<a href="{{$tag_id_3}}">{{$tag_name_3}}</a>
							</li>
							@endif
						</ul>
					</div>
				</div>
				<div class="user-date">
					<div class="user">
						<a href="/user/{{ Auth::user()->user_id }}"><img src="https://placehold.jp/50x50.png" width="40px"><span>{{ Auth::user()->user_id }}</span></a>
					</div>
					<div class="date">
						<div class="top-entry-datetime">投稿日時：{{$created_at}}</div>
					</div>
				</div>
				<div class="question-content"><p>{{$question_content}}</p></div>
				<div class="question-addition">
					<div class="addition-header"><span>補足</span></div>
					<div class="addition-body"><p>{{$question_addition}}</p></div>
				</div>
			</div>

			<div>
				<div class="btn-update">
					<button type="button" onclick="history.back()" class="btn btn-outline-secondary">
						{{ __('戻る') }}
					</button>
					<button name="action" value="post" class="btn btn-outline-danger">
						{{ __('投稿する') }}
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
@include('layouts.footer')