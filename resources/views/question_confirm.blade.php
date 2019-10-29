@section('title', 'Ketchup')
@section('description', 'Ketchupは音楽制作者のためのQ&Aサイトです。 作詞・作曲から編曲・DAW操作までDTMや曲作りに関する悩みを解決しましょう。')

@section('pageCss')
<link href="{{ asset('css/question.css') }}" rel="stylesheet">
@endsection

@include('layouts.head')

<div class="card">
	<div class="card-header">{{ __('質問投稿') }}</div>

	<div class="card-body">
		<form method="POST" action="question/confirm">
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
				<label for="tag_id_1" class="col-md-4 col-form-label text-md-right">{{ __('タグ1') }}</label>
				<div class="col-md-6">
					{{$tag_id_1}}
				</div>
			</div>

			<div class="form-group row">
				<label for="tag_id_2" class="col-md-4 col-form-label text-md-right">{{ __('タグ2') }}</label>
				<div class="col-md-6">
					{{$tag_id_2}}
				</div>
			</div>

			<div class="form-group row">
				<label for="tag_id_2" class="col-md-4 col-form-label text-md-right">{{ __('タグ2') }}</label>
				<div class="col-md-6">
					{{$tag_id_3}}
				</div>
			</div>

			<div class="form-group row mb-0">
				<div class="col-md-6 offset-md-4">
					<button type="return" class="btn btn-primary">
						{{ __('戻る') }}
					</button>
					<button type="submit" class="btn btn-primary">
						{{ __('登録') }}
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
@include('layouts.footer')