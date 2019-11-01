@section('title', 'Ketchup')
@section('description', 'Ketchupは音楽制作者のためのQ&Aサイトです。 作詞・作曲から編曲・DAW操作までDTMや曲作りに関する悩みを解決しましょう。')

@section('pageCss')
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
<link href="{{ asset('css/question_detail.css') }}" rel="stylesheet">
@endsection

@include('layouts.head')

<a href="{{ url('/') }}">トップ</a> > <a href="{{$question['tag_id_1']}}">{{$question['tag_name_1']}}</a> に関する質問

<div class="ketchup-container">
	<div class="row justify-content-center">
		<div class="top-contents">
			<div class="question_title">
				{{$question['question_title']}}
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
			<div>
				@if ($question['close_flg'] === 0)
				<p class="top-question-status">募集中</p>
				@elseif($question['close_flg'] === 1)
				<p class="top-question-status-finish">解決済</p>
				@endif
			</div>
			<div class="user">
				<div class="top-question-user d-inline-block"><a href="#"><img src="{{$question['image']}}">{{$question['user_id']}}</a></div>
			</div>
			<div class=""> 
				<p class="question-content">{{$question['question_content']}}</p>
			</div>
			<div class="">
				<div class="top-entry-datetime"><i class="fas fa-clock"></i>{{$question['created_at']}}</div>
			</div>

		</div>
	@include('layouts.side')
	</div>
</div>
@include('layouts.footer')