@section('title', 'Ketchup')
@section('description', 'Ketchupは音楽制作者のためのQ&Aサイトです。 作詞・作曲から編曲・DAW操作までDTMや曲作りに関する悩みを解決しましょう。')

@section('pageCss')
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@include('layouts.head')

@guest
@include('layouts.top')
@endguest

<div class="ketchup-container">
	<div class="row justify-content-center">
		<div class="top-contents">
			<div class="top-contents-header">
				<form class="form-inline float-right">
					<div class="dropdown">
						<select class="form-control" id="refine">
							<option>タグで絞り込む</option>
							<option>作詞</option>
							<option>作曲</option>
							<option>編曲・アレンジ</option>
							<option>楽器・演奏</option>
							<option>レコーディング</option>
							<option>ミックスダウン</option>
							<option>マスタリング</option>
							<option>DAW・DTM全般</option>
							<option>その他</option>
						</select>
					</div>
					<div class="dropdown ml-2">
						<select class="form-control" id="sort">
							<option>並べ替え</option>
							<option>質問日時が新しい順</option>
							<option>質問日時が古い順</option>
							<option>回答日時が新しい順</option>
							<option>回答数が多い順</option>
							<option>回答数が少ない順</option>
							<option>いいねが多い順</option>
						</select>
					</div>
				</form>
			</div>

			<ul class="top-question-list">
				@foreach ($question_list as $question)
				<li class="top-question">
					<div class="top-question-left">
						<div class="top-answer-count">
							<div class="top-answer-count-div"><a class="top-answer-count-a" href="questions/{{$question['question_id']}}">回答数</a></div>
								<p class="top-answer-count-p"><a class="top-answer-count-a" href="questions/{{$question['question_id']}}">{{$question['count_answer']}}</a></p>
							</a>
						</div>
						<div>
							@if ($question['close_flg'] === 0)
							<p class="top-question-status">募集中</p>
							@elseif($question['close_flg'] === 1)
							<p class="top-question-status-finish">解決済</p>
							@endif
						</div>
					</div>
					<div class="top-question-inner d-inline-block">
						<div class="top-question-title">
							<a href="questions/{{$question['question_id']}}">{{$question['question_title']}}</a>
						</div>
						<div></div>
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
						<div class="top-question-data">
							<div class="top-entry-datetime d-inline-block"><i class="fas fa-clock"></i>{{$question['created_at']}}</div>
							<!-- <div class="top-question-user d-inline-block"><a href="#"><img src="{{$question['image']}}">{{$question['user_id']}}</a></div> -->
							<div class="top-question-user d-inline-block"><a href="#"><img src="{{ asset('img/common/test-user.png') }}">{{$question['user_id']}}</a></div>
							<div class="top-good-count d-inline-block"><i class="fas fa-thumbs-up"></i>{{$question['good_question']}}</div>
						</div>	
					</div>
				</li>
				@endforeach
			</ul>
			{{ $question_list->links() }}
		</div>
	@include('layouts.side')
	</div>
</div>
@include('layouts.footer')