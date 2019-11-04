@section('title', 'Ketchup')
@section('description', 'Ketchupは音楽制作者のためのQ&Aサイトです。 作詞・作曲から編曲・DAW操作までDTMや曲作りに関する悩みを解決しましょう。')

@section('pageCss')
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
<link href="{{ asset('css/question_detail.css') }}" rel="stylesheet">
@endsection

@include('layouts.head')

<div class="breadcrumb">
	<a href="{{ url('/') }}"><span>トップ</span></a><span>/</span><a href="{{$question['tag_id_1']}}">{{$question['tag_name_1']}}</a><span>に関する質問</span>
</div>

<div class="ketchup-container">
	<div class="row justify-content-center">
		<div class="top-contents">
			<div class="question-area">
				<div class="question_title">
					<h1>{{$question['question_title']}}</h1>
				</div>
				<div class="top-question-inner d-inline-block">
					<div class="top-question-tag">
						<ul class="question-tag-ul">
							<li class="question-tag-li">
								<a href="{{$question['tag_id_1']}}">{{$question['tag_name_1']}}</a>
							</li>
							@if ($question['tag_table_id_2'] !== 0)
							<li class="question-tag-li">
								<a href="{{$question['tag_id_2']}}">{{$question['tag_name_2']}}</a>
							</li>
							@endif
							@if ($question['tag_table_id_3'] !== 0)
							<li class="question-tag-li">
								<a href="{{$question['tag_id_3']}}">{{$question['tag_name_3']}}</a>
							</li>
							@endif
						</ul>
					</div>
				</div>
				<div class="user-date">
					<div class="user">
						<a href="#"><img src="https://placehold.jp/50x50.png" width="50px"><span>{{$question['user_id']}}</span></a>
					</div>
					<div class="date">
						<div class="top-entry-datetime">投稿日時：{{$question['created_at']}}</div>
					</div>
				</div>
				<div class="question-content"><p>{{$question['question_content']}}</p></div>
				<div class="question-status">
					<div class="count-pv">
						PV数：<span class="count-pv">5</span>
					</div>
					<div class="count-answer">
						回答数：<span class="count-pv">5</span>
					</div>
					<div class="status">
						@if ($question['close_flg'] === 0)
						<p class="top-question-status">募集中</p>
						@elseif($question['close_flg'] === 1)
						<p class="top-question-status-finish">解決済</p>
						@endif
					</div>
				</div>
				<div class="question-button">
					<div class="count-good">
					<a href="#"><i class="fas fa-thumbs-up"></i></a>
					<div class="count-fukidashi"><a href="#"><p>5</p></a></div>
					<button type="button" class="btn btn-outline-secondary">回答する</button>
				</div>
				</div>
			</div>
			<div class="answer-area">
				<div class="answer-header">
					回答一覧
				</div>
				<div class="answer-content">
					<p class="answer-none">まだ回答がありません。</p>
				</div>
				<div class="answer-write-area">
					<div class="answer-write-header">
					回答する
					</div>
					<div class="answer-write-content">
						<div class="user">
							<a href="#"><img src="https://placehold.jp/50x50.png" width="50px"><span>{{$question['user_id']}}</span></a>
						</div>
						<textarea></textarea>
						<div class="answer-write-button"><button type="button" class="btn btn-outline-secondary answer-button">回答する</button></div>
					</div>
				</div>
			</div>
		</div>
	@include('layouts.side')
	</div>
</div>
@include('layouts.footer')