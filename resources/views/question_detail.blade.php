@section('title', 'Ketchup')
@section('description', 'Ketchupは音楽制作者のためのQ&Aサイトです。 作詞・作曲から編曲・DAW操作までDTMや曲作りに関する悩みを解決しましょう。')

@section('pageCss')
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
<link href="{{ asset('css/question_detail.css') }}" rel="stylesheet">
@endsection

@include('layouts.head')

<div class="breadcrumb">
	<a href="{{ url('/') }}"><span>トップ</span></a><span>/</span><a href="{{$question['tag_id_1']}}"><span>{{$question['tag_name_1']}}</span></a><span>に関する質問</span>
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
						<a href="#"><img src="https://placehold.jp/50x50.png" width="40px"><span>{{$question['user_id']}}</span></a>
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
						回答数：<span class="count-pv">{{$count_answer}}</span>
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
						<button type="button" class="btn btn-outline-danger">回答する</button>
					</div>
				</div>
			</div>
			<div class="answer-area">
				<div class="answer-header">
					回答一覧
				</div>
				<div class="answer-content">
					@if (count($answer_data) === 0)
					<p class="answer-none">まだ回答がありません。</p>
					@else
						@foreach ($answer_data as $answer)
							<div class="answer-reply">
								<div class="answer-list">
									<div class="user-list">
										<div class="user">
											<a href="#"><img src="https://placehold.jp/50x50.png" width="40px"><span>{{$answer['user_id']}}</span></a>
										</div>
										<div class="date">
											<div class="top-entry-datetime">投稿日時：{{$answer['created_at']}}</div>
										</div>
									</div>
									<p>{{$answer['answer_content']}}</p>
									<div class="question-button">
									<div class="count-good">
										<a href="#"><i class="fas fa-thumbs-up"></i></a>
										<div class="count-fukidashi"><a href="#"><p>5</p></a></div>
										@isset ($answer['reply_data'])
										@if(count($answer['reply_data']) === 0)
										<button type="button" class="btn btn-outline-secondary reply-display">返信する</button>
										@else
										<button type="button" class="btn btn-outline-secondary reply-display">返信 ( {{count($answer['reply_data'])}} )</button>
										@endif
										@endisset
									</div>
								</div>
								</div>
								<div class="reply-list">
									@isset ($answer['reply_data'])
									@foreach ($answer['reply_data'] as $reply)
									<div class="reply-content">
										<div class="user-list">
											<div class="user">
												<a href="#"><img src="https://placehold.jp/50x50.png" width="30px"><span>{{$reply['user_id']}}</span></a>
											</div>
											<div class="date">
												<div class="top-entry-datetime">投稿日時：{{$reply['created_at']}}</div>
											</div>
										</div>
										<p>{{$reply['reply_content']}}</p>
									</div>
									@endforeach
									@endisset
									<div class="reply-write-content">
										<div class="user">
											<a href="#"><img src="https://placehold.jp/50x50.png" width="30px"><span>{{ Auth::user()->user_id }}</span></a>
										</div>
										<form method="POST" class="reply" name="reply" action="reply">
											@csrf
											<input type="hidden" name="question_id" value="{{$question_id}}">
											<input type="hidden" name="answer_id" class="answer-id" value="{{$answer['answer_id']}}">
											<textarea class="reply-area" name="reply_content"></textarea>
										</form>
										<div class="reply-write-button"><button type="button" class="btn btn-outline-danger reply-button">返信する</button></div>
									</div>
								</div>
							</div>
						@endforeach
					@endif
				</div>
				<div class="answer-write-area">
					<div class="answer-write-header">
					回答する
					</div>
					<div class="answer-write-content">
						<div class="user">
							<a href="#"><img src="https://placehold.jp/50x50.png" width="40px"><span>{{ Auth::user()->user_id }}</span></a>
						</div>
						<textarea id="answer_area"></textarea>
						<div class="answer-write-button"><button type="button" class="btn btn-outline-danger answer-button" data-toggle="modal" data-target="#modal_answer" id="answer_button">回答する</button></div>
					</div>
				</div>
			</div>
		</div>
	@include('layouts.side')
	</div>
</div>

<!-- 回答内容確認モーダル -->
<div class="modal fade" id="modal_answer" tabindex="-1" role="dialog" aria-labelledby="modalAnswer" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalAnswer">回答内容確認</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" name="answer" id="answer" action="answer">
					@csrf
					<p id="answer_content_label"></p>
					<input type="hidden" name="answer_content" id="answer_content">
					<input type="hidden" name="question_id" value="{{$question_id}}">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">閉じる</button>
				<button type="button" class="btn btn-outline-danger" id="answer_post">回答する</button>
			</div>
		</div>
	</div>
</div>

@section('pageJs')
<script src="http://dev.ketchup/js/question.js"></script>
@endsection

@include('layouts.footer')