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
	<div class="container-center">
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
						PV数：<span class="count-pv">{{$question['count_pv']}}</span>
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
						<a id="count_good" @if($user_type !== 'logout') href="javascript:void(0)" @endif @if ($good_question === 1) class="question-good" @endif>
							<i class="fas fa-thumbs-up"></i>
							<div class="count-fukidashi"><p>{{$count_good_quesiton}}</p></div>
						</a>
						@if($user_type === 'questioner' && !isset($question['question_addition']) && $question['close_flg'] === 0)
						<a href="{{$question_id}}/addition"><button type="button" class="btn btn-outline-secondary">補足する</button></a>
						@elseif($user_type === 'login')
						<button type="button" class="btn btn-outline-danger" id="move_answer">回答する</button>
						@endif
					</div>
				</div>
			</div>
			<div class="answer-area">
				<div class="answer-header">
					回答一覧
				</div>
				<div>
					@if (count($answer_data) === 0)
					<p class="answer-none">まだ回答がありません。</p>
					@else
						@foreach ($answer_data as $answer)
							<div class="answer-reply">
								<div class="answer-list">
									@if ($loop->first && $question['close_flg'] === 1)
									<div class="best-answer-header">
										<p><i class="fas fa-crown gold"></i> ベストアンサーに選ばれた回答 <i class="fas fa-crown gold"></i></p>
									</div>
									@endif
									<input type="hidden" name="answer_id" class="answer-id" value="{{$answer['answer_id']}}">
									<div class="user-list">
										<div class="user">
											<a href="#"><img src="https://placehold.jp/50x50.png" width="40px"><span class="user-id">{{$answer['user_id']}}</span></a>
										</div>
										<div class="date">
											<div class="top-entry-datetime">投稿日時：{{$answer['created_at']}}</div>
										</div>
									</div>
									<p class="answer-content">{{$answer['answer_content']}}</p>
									<div class="question-button">
									<div class="count-good">
										<a @if($user_type !== 'logout') href="javascript:void(0)" @endif class="answer-good @if ($user_type !== 'logout' && $answer['good_answer'] === 1) question-good @endif">
											<i class="fas fa-thumbs-up"></i>
											<div class="count-fukidashi"><p>{{$answer['count_good_answer']}}</p></div>
										</a>
										@if($user_type === 'questioner' && $question['close_flg'] === 0)
										<button type="button" class="btn btn-outline-danger best-answer" data-toggle="modal" data-target="#modal_best_answer">ベストアンサーに選ぶ</button>
										@endif
										@isset ($answer['reply_data'])
										@if(count($answer['reply_data']) === 0 && $question['close_flg'] === 1)
										@elseif(count($answer['reply_data']) === 0)
											@if($user_type === 'logout')
											@else
											<button type="button" class="btn btn-outline-secondary reply-display">返信する</button>
											@endif
										@else
										<button type="button" class="btn btn-outline-secondary reply-display">返信 ( {{count($answer['reply_data'])}} )</button>
										@endif
										@endisset
										</div>
									</div>
								</div>
								@if ($loop->first && $question['close_flg'] === 1)
								<div class="best-answer-footer">
									<p class="from-questioner">質問者からのコメント</p>
									<p class="question-last-comment">{{$question['last_comment']}}</p>
									<p class="question-last-comment-date">{{$question['updated_at']}}</p>
								</div>
								@endif
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
									@if($user_type !== 'logout' && $question['close_flg'] === 0)
									<div class="reply-write-content">
										<div class="user d-inline-block">
											<a href="#"><img src="https://placehold.jp/50x50.png" width="30px"><span>{{ Auth::user()->user_id }}</span></a>
										</div>
										<div class="content-input-p d-inline-block mt-2 float-right"><span class="text-danger">※</span><span>5文字以上1000文字以下</span></div>
										<input type="hidden" name="answer_id" class="answer-id" value="{{$answer['answer_id']}}">
										<textarea class="reply-area" maxlength='1000'></textarea>
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
						<div class="user d-inline-block">
							<a href="#"><img src="https://placehold.jp/50x50.png" width="40px"><span>{{ Auth::user()->user_id }}</span></a>
						</div>
						<div class="content-input-p d-inline-block mt-3 float-right"><span class="text-danger">※</span><span>5文字以上2000文字以下</span></div>
						<textarea id="answer_area" maxlength='2000'></textarea>
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
				<h5 class="modal-title" id="modalBestAnswer">ベストアンサー確認</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" name="best_answer" id="best_answer" action="best_answer">
					@csrf
					<div class="user-list">
						<div class="user">
							<a href="#"><img src="https://placehold.jp/50x50.png" width="40px"><span id="user_id"></span></a>
						</div>
					</div>
					<p id="best_answer_content_label"></p>
					<div class="last-comment-area">
						<p class="content-input-p"><span class="text-danger">※</span>コメント：<span>5文字以上40文字以下</span></p>
						<textarea class="last-comment" name="last_comment" id="last_comment" maxlength='40'>ありがとうございました。</textarea>
					</div>
					<input type="hidden" name="question_id" value="{{$question_id}}">
					<input type="hidden" name="best_answer_id" id="best_answer_id">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">閉じる</button>
				<button type="button" class="btn btn-outline-danger" id="best_answer_post">ベストアンサーに選ぶ</button>
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
@if($user_type !== 'logout')
<script src="{{ asset('js/question_good.js') }}"></script>
@endif
<script src="{{ asset('js/question_common.js') }}"></script>
@endsection
@include('layouts.footer')