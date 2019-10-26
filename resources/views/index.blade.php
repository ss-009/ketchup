@include('layouts.head')
@include('layouts.top')
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
				<li class="top-question">
					<div class="top-question-left">
						<div class="top-answer-count">
							<div class="top-answer-count-div"><a class="top-answer-count-a" href="#">回答数</a></div>
								<p class="top-answer-count-p"><a class="top-answer-count-a" href="#">10</a></p>
							</a>
						</div>
						<div>
							<p class="top-question-status">募集中</p>
						</div>
					</div>
					<div class="top-question-inner d-inline-block">
						<div class="top-question-title">
							<a href="#">テストテストテストテストテストテスト</a>
						</div>
						<div></div>
						<div class="top-question-tag">
							<ul class="question-tag-ul">
								<li class="question-tag-li">
									<a href="#">作曲</a>
								</li>
								<li class="question-tag-li">
									<a href="#">編曲・アレンジ</a>
								</li>
							</ul>
						</div>
						<div class="top-question-data">
							<div class="top-entry-datetime d-inline-block"><i class="fas fa-clock"></i>2019/10/23 09:31:43</div>
							<div class="top-question-user d-inline-block"><a href="#"><img src="{{ asset('img/common/test-user.png') }}">bell-mere</a></div>
							<div class="top-good-count d-inline-block"><i class="fas fa-thumbs-up"></i>20</div>
						</div>	
					</div>
				</li>

				<li class="top-question">
					<div class="top-question-left">
						<div class="top-answer-count">
							<div class="top-answer-count-div"><a class="top-answer-count-a" href="#">回答数</a></div>
								<p class="top-answer-count-p"><a class="top-answer-count-a" href="#">10</a></p>
							</a>
						</div>
						<div>
							<p class="top-question-status-finish">解決済</p>
						</div>
					</div>
					<div class="top-question-inner d-inline-block">
						<div class="top-question-title">
							<a href="#">テストテストテストテストテストテストテストテストテストテストテストテスト</a>
						</div>
						<div></div>
						<div class="top-question-tag">
							<ul class="question-tag-ul">
								<li class="question-tag-li">
									<a href="#">レコーディング</a>
								</li>
								<li class="question-tag-li">
									<a href="#">DAW・DTM全般</a>
								</li>
								<li class="question-tag-li">
									<a href="#">マスタリング</a>
								</li>
							</ul>
						</div>
						<div class="top-question-data">
							<div class="top-entry-datetime d-inline-block"><i class="fas fa-clock"></i>2019/10/23 09:31:43</div>
							<div class="top-question-user d-inline-block"><a href="#"><img src="{{ asset('img/common/test-user.png') }}">bell-mere</a></div>
							<div class="top-good-count d-inline-block"><i class="fas fa-thumbs-up"></i>20</div>
						</div>	
					</div>
				</li>

				<li class="top-question">
					<div class="top-question-left">
						<div class="top-answer-count">
							<div class="top-answer-count-div"><a class="top-answer-count-a" href="#">回答数</a></div>
								<p class="top-answer-count-p"><a class="top-answer-count-a" href="#">10</a></p>
							</a>
						</div>
						<div>
							<p class="top-question-status">募集中</p>
						</div>
					</div>
					<div class="top-question-inner d-inline-block">
						<div class="top-question-title">
							<a href="#">テストテストテストテストテストテストテストテストテストテストテストテスト</a>
						</div>
						<div></div>
						<div class="top-question-tag">
							<ul class="question-tag-ul">
								<li class="question-tag-li">
									<a href="#">レコーディング</a>
								</li>
								<li class="question-tag-li">
									<a href="#">DAW・DTM全般</a>
								</li>
								<li class="question-tag-li">
									<a href="#">マスタリング</a>
								</li>
							</ul>
						</div>
						<div class="top-question-data">
							<div class="top-entry-datetime d-inline-block"><i class="fas fa-clock"></i>2019/10/23 09:31:43</div>
							<div class="top-question-user d-inline-block"><a href="#"><img src="{{ asset('img/common/test-user.png') }}">bell-mere</a></div>
							<div class="top-good-count d-inline-block"><i class="fas fa-thumbs-up"></i>20</div>
						</div>	
					</div>
				</li>
			
				<li class="top-question">
					<div class="top-question-left">
						<div class="top-answer-count">
							<div class="top-answer-count-div"><a class="top-answer-count-a" href="#">回答数</a></div>
								<p class="top-answer-count-p"><a class="top-answer-count-a" href="#">10</a></p>
							</a>
						</div>
						<div>
							<p class="top-question-status">募集中</p>
						</div>
					</div>
					<div class="top-question-inner d-inline-block">
						<div class="top-question-title">
							<a href="#">テストテストテストテストテストテストテストテストテストテストテストテスト</a>
						</div>
						<div></div>
						<div class="top-question-tag">
							<ul class="question-tag-ul">
								<li class="question-tag-li">
									<a href="#">レコーディング</a>
								</li>
								<li class="question-tag-li">
									<a href="#">DAW・DTM全般</a>
								</li>
								<li class="question-tag-li">
									<a href="#">マスタリング</a>
								</li>
							</ul>
						</div>
						<div class="top-question-data">
							<div class="top-entry-datetime d-inline-block"><i class="fas fa-clock"></i>2019/10/23 09:31:43</div>
							<div class="top-question-user d-inline-block"><a href="#"><img src="{{ asset('img/common/test-user.png') }}">bell-mere</a></div>
							<div class="top-good-count d-inline-block"><i class="fas fa-thumbs-up"></i>20</div>
						</div>	
					</div>
				</li>

				<li class="top-question">
					<div class="top-question-left">
						<div class="top-answer-count">
							<div class="top-answer-count-div"><a class="top-answer-count-a" href="#">回答数</a></div>
								<p class="top-answer-count-p"><a class="top-answer-count-a" href="#">10</a></p>
							</a>
						</div>
						<div>
							<p class="top-question-status">募集中</p>
						</div>
					</div>
					<div class="top-question-inner d-inline-block">
						<div class="top-question-title">
							<a href="#">テストテストテストテストテストテストテストテストテストテストテストテスト</a>
						</div>
						<div></div>
						<div class="top-question-tag">
							<ul class="question-tag-ul">
								<li class="question-tag-li">
									<a href="#">レコーディング</a>
								</li>
								<li class="question-tag-li">
									<a href="#">DAW・DTM全般</a>
								</li>
								<li class="question-tag-li">
									<a href="#">マスタリング</a>
								</li>
							</ul>
						</div>
						<div class="top-question-data">
							<div class="top-entry-datetime d-inline-block"><i class="fas fa-clock"></i>2019/10/23 09:31:43</div>
							<div class="top-question-user d-inline-block"><a href="#"><img src="{{ asset('img/common/test-user.png') }}">bell-mere</a></div>
							<div class="top-good-count d-inline-block"><i class="fas fa-thumbs-up"></i>20</div>
						</div>	
					</div>
				</li>

				<li class="top-question">
					<div class="top-question-left">
						<div class="top-answer-count">
							<div class="top-answer-count-div"><a class="top-answer-count-a" href="#">回答数</a></div>
								<p class="top-answer-count-p"><a class="top-answer-count-a" href="#">10</a></p>
							</a>
						</div>
						<div>
							<p class="top-question-status">募集中</p>
						</div>
					</div>
					<div class="top-question-inner d-inline-block">
						<div class="top-question-title">
							<a href="#">テストテストテストテストテストテストテストテストテストテストテストテスト</a>
						</div>
						<div></div>
						<div class="top-question-tag">
							<ul class="question-tag-ul">
								<li class="question-tag-li">
									<a href="#">レコーディング</a>
								</li>
								<li class="question-tag-li">
									<a href="#">DAW・DTM全般</a>
								</li>
								<li class="question-tag-li">
									<a href="#">マスタリング</a>
								</li>
							</ul>
						</div>
						<div class="top-question-data">
							<div class="top-entry-datetime d-inline-block"><i class="fas fa-clock"></i>2019/10/23 09:31:43</div>
							<div class="top-question-user d-inline-block"><a href="#"><img src="{{ asset('img/common/test-user.png') }}">bell-mere</a></div>
							<div class="top-good-count d-inline-block"><i class="fas fa-thumbs-up"></i>20</div>
						</div>
					</div>
				</li>

				<li class="top-question">
					<div class="top-question-left">
						<div class="top-answer-count">
							<div class="top-answer-count-div"><a class="top-answer-count-a" href="#">回答数</a></div>
								<p class="top-answer-count-p"><a class="top-answer-count-a" href="#">10</a></p>
							</a>
						</div>
						<div>
							<p class="top-question-status">募集中</p>
						</div>
					</div>
					<div class="top-question-inner d-inline-block">
						<div class="top-question-title">
							<a href="#">テストテストテストテストテストテストテストテストテストテストテストテスト</a>
						</div>
						<div></div>
						<div class="top-question-tag">
							<ul class="question-tag-ul">
								<li class="question-tag-li">
									<a href="#">レコーディング</a>
								</li>
								<li class="question-tag-li">
									<a href="#">DAW・DTM全般</a>
								</li>
								<li class="question-tag-li">
									<a href="#">マスタリング</a>
								</li>
							</ul>
						</div>
						<div class="top-question-data">
							<div class="top-entry-datetime d-inline-block"><i class="fas fa-clock"></i>2019/10/23 09:31:43</div>
							<div class="top-question-user d-inline-block"><a href="#"><img src="{{ asset('img/common/test-user.png') }}">bell-mere</a></div>
							<div class="top-good-count d-inline-block"><i class="fas fa-thumbs-up"></i>20</div>
						</div>
					</div>
				</li>

				<li class="top-question">
					<div class="top-question-left">
						<div class="top-answer-count">
							<div class="top-answer-count-div"><a class="top-answer-count-a" href="#">回答数</a></div>
								<p class="top-answer-count-p"><a class="top-answer-count-a" href="#">10</a></p>
							</a>
						</div>
						<div>
							<p class="top-question-status">募集中</p>
						</div>
					</div>
					<div class="top-question-inner d-inline-block">
						<div class="top-question-title">
							<a href="#">テストテストテストテストテストテストテストテストテストテストテストテスト</a>
						</div>
						<div></div>
						<div class="top-question-tag">
							<ul class="question-tag-ul">
								<li class="question-tag-li">
									<a href="#">レコーディング</a>
								</li>
								<li class="question-tag-li">
									<a href="#">DAW・DTM全般</a>
								</li>
								<li class="question-tag-li">
									<a href="#">マスタリング</a>
								</li>
							</ul>
						</div>
						<div class="top-question-data">
							<div class="top-entry-datetime d-inline-block"><i class="fas fa-clock"></i>2019/10/23 09:31:43</div>
							<div class="top-question-user d-inline-block"><a href="#"><img src="{{ asset('img/common/test-user.png') }}">bell-mere</a></div>
							<div class="top-good-count d-inline-block"><i class="fas fa-thumbs-up"></i>20</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
	@include('layouts.side')
	</div>
</div>
@include('layouts.footer')