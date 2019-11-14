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
				@if(isset($question['question_addition']))
				<div class="question-addition">
					<div class="addition-header"><span>補足</span></div>
					<div class="addition-body"><p>{{$question['question_addition']}}</p></div>
				</div>
				@endif
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
						@if($user_type === 'questioner' && !isset($question['question_addition']))
						<a href="{{$question_id}}/addition"><button type="button" class="btn btn-outline-secondary">補足する</button></a>
						@elseif($user_type === 'login')
						<button type="button" class="btn btn-outline-danger">回答する</button>
						@endif
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
										@if($user_type === 'questioner' && $question['close_flg'] === 0)
										<button type="button" class="btn btn-outline-danger best-answer" data-toggle="modal" data-target="#modal_best_answer" id="best_answer_button">ベストアンサーに選ぶ</button>
										@endif
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
									@if($user_type !== 'logout')
									<div class="reply-write-content">
										<div class="user">
											<a href="#"><img src="https://placehold.jp/50x50.png" width="30px"><span>{{ Auth::user()->user_id }}</span></a>
										</div>
										<input type="hidden" name="answer_id" class="answer-id" value="{{$answer['answer_id']}}">
										<textarea class="reply-area"></textarea>
										<div class="reply-write-button"><button type="button" class="btn btn-outline-danger reply-button" data-toggle="modal" data-target="#modal_reply">返信する</button></div>
									</div>
									@endif
								</div>
							</div>
						@endforeach
					@endif
				</div>
				@if($user_type === 'login' && $question['close_flg'] === 0)
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
				@endif
			</div>
		</div>
	@include('layouts.side')
	</div>
</div>

@if($user_type === 'login' && $question['close_flg'] === 0)
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
@endif

@if($user_type !== 'logout' && $question['close_flg'] === 0)
<!-- 返信内容確認モーダル -->
<div class="modal fade" id="modal_reply" tabindex="-1" role="dialog" aria-labelledby="modalReply" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalReply">返信内容確認</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" name="reply" id="reply" action="reply">
					@csrf
					<p id="reply_content_label"></p>
					<input type="hidden" name="reply_content" id="reply_content">
					<input type="hidden" name="question_id" value="{{$question_id}}">
					<input type="hidden" name="answer_id" id="answer_id">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">閉じる</button>
				<button type="button" class="btn btn-outline-danger" id="reply_post">返信する</button>
			</div>
		</div>
	</div>
</div>
@endif

@if($user_type === 'questioner' && $question['close_flg'] === 0)
<!-- ベストアンサー確認モーダル -->
<div class="modal fade" id="modal_best_answer" tabindex="-1" role="dialog" aria-labelledby="modalBestAnswer" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalBestAnswer">ベストアンサー選択</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" name="best_answer" id="best_answer" action="best_answer">
					@csrf
					<p id="best_answer_content_label"></p>
					<input type="hidden" name="last_comment" id="last_comment">
					<input type="hidden" name="question_id" value="{{$question_id}}">
					<input type="hidden" name="best_answer_id" id="best_answer_id">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">閉じる</button>
				<button type="button" class="btn btn-outline-danger" id="answer_post">ベストアンサーに選ぶ</button>
			</div>
		</div>
	</div>
</div>
@endif

@section('pageJs')
@if($user_type === 'questioner' && $question['close_flg'] === 0)
<script src="{{ asset('js/question.js') }}"></script>
@elseif($user_type === 'login' && $question['close_flg'] === 0)
<script src="{{ asset('js/question_answer.js') }}"></script>
@endif
<script src="{{ asset('js/question_reply.js') }}"></script>
@endsection
@include('layouts.footer')