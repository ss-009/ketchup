@section('title', 'Ketchup')
@section('description', 'Ketchupは音楽制作者のためのQ&Aサイトです。 作詞・作曲から編曲・DAW操作までDTMや曲作りに関する悩みを解決しましょう。')

@section('pageCss')
<link href="{{ asset('css/question.css') }}" rel="stylesheet">
@endsection

@include('layouts.head')

<div class="card">
	<div class="card-header">{{ __('補足内容確認') }}</div>

	<div class="card-body">
		<form method="POST" action="complete">
			@csrf

			<div class="form-group row">
				<label for="question_title" class="col-md-4 col-form-label text-md-right">{{ __('質問タイトル') }}</label>

				<div class="col-md-6">
					{{$question_title}}
				</div>
			</div>

			<div class="form-group row">
				<label for="question_content" class="col-md-4 col-form-label text-md-right">{{ __('質問本文') }}</label>

				<div class="col-md-6">
					{{$question_content}}
				</div>
			</div>

			<div class="form-group row">
				<label for="question_addition" class="col-md-4 col-form-label text-md-right">{{ __('補足内容') }}</label>

				<div class="col-md-6">
					{{$question_addition}}
				</div>
			</div>

			<div class="form-group row">
				<label for="tag1" class="col-md-4 col-form-label text-md-right">{{ __('タグ1') }}</label>
				<div class="col-md-6">
					{{$tag_name_1}}<span class="d-none" id="tag_id_1">{{$tag_id_1}}</span>
				</div>
			</div>

			<div class="form-group row">
				<label for="tag2" class="col-md-4 col-form-label text-md-right">{{ __('タグ2') }}</label>
				<div class="col-md-6">
					{{$tag_name_2}}<span class="d-none" id="tag_id_2">{{$tag_id_2}}</span>
				</div>
			</div>

			<div class="form-group row">
				<label for="tag3" class="col-md-4 col-form-label text-md-right">{{ __('タグ3') }}</label>
				<div class="col-md-6">
					{{$tag_name_3}}<span class="d-none" id="tag_id_3">{{$tag_id_3}}</span>
				</div>
			</div>

			<div class="form-group row mb-0">
				<div class="col-md-6 offset-md-4">
					<button type="button" onclick="history.back()" class="btn btn-primary">
						{{ __('戻る') }}
					</button>
					<button name="action" value="post" class="btn btn-primary">
						{{ __('登録') }}
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
@include('layouts.footer')