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
				<label for="question_title" class="col-md-4 col-form-label text-md-right"><span class="required">※</span>{{ __('質問タイトル') }}</label>

				<div class="col-md-6">
					<input id="question_title" type="text" class="form-control @error('question_title') is-invalid @enderror" name="question_title" value="{{ old('question_title') }}" required autocomplete="question_title">

					@error('question_title')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>

			<div class="form-group row">
				<label for="question_content" class="col-md-4 col-form-label text-md-right"><span class="required">※</span>{{ __('質問本文') }}</label>

				<div class="col-md-6">
					<textarea id="question_content" type="text" class="form-control @error('question_content') is-invalid @enderror" name="question_content" required>{{ old('question_content') }}</textarea>

					@error('question_content')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>

			<div class="form-group row">
				<label for="tag_id_1" class="col-md-4 col-form-label text-md-right"><span class="required">※</span>{{ __('タグ1') }}</label>
				<div class="dropdown">
					<select class="form-control @error('tag_id_1') is-invalid @enderror" name="tag_id_1" id="tag_id_1">
						<option @if(old("tag_id_1") == "0") selected @endif value="0">タグを選択</option>
						@foreach($tag_list as $tag)
						<option @if(old("tag_id_1") == $tag['id']) selected @endif value={{$tag['id']}}>{{$tag['tag_name']}}</option>
						@endforeach
					</select>

					@error('tag_id_1')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>

			<div class="form-group row">
			<label for="tag_id_2" class="col-md-4 col-form-label text-md-right">{{ __('タグ2') }}</label>
				<div class="dropdown">
					<select class="form-control @error('tag_id_2') is-invalid @enderror" name="tag_id_2" id="tag_id_2">
						<option @if(old("tag_id_2") == "0") selected @endif value="0">タグを選択</option>
						<option @if(old("tag_id_2") == "1") selected @endif value="1">作詞</option>
						<option @if(old("tag_id_2") == "2") selected @endif value="2">作曲</option>
						<option @if(old("tag_id_2") == "3") selected @endif value="3">編曲・アレンジ</option>
						<option @if(old("tag_id_2") == "4") selected @endif value="4">楽器・演奏</option>
						<option @if(old("tag_id_2") == "5") selected @endif value="5">レコーディング</option>
						<option @if(old("tag_id_2") == "6") selected @endif value="6">ミックスダウン</option>
						<option @if(old("tag_id_2") == "7") selected @endif value="7">マスタリング</option>
						<option @if(old("tag_id_2") == "8") selected @endif value="8">DAW・DTM全般</option>
						<option @if(old("tag_id_2") == "9") selected @endif value="9">その他</option>
					</select>

					@error('tag_id_2')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>

			<div class="form-group row">
			<label for="tag_id_3" class="col-md-4 col-form-label text-md-right">{{ __('タグ3') }}</label>
				<div class="dropdown">
					<select class="form-control @error('tag_id_3') is-invalid @enderror" name="tag_id_3" id="tag_id_3">
						<option @if(old("tag_id_3") == "0") selected @endif value="0">タグを選択</option>
						<option @if(old("tag_id_3") == "1") selected @endif value="1">作詞</option>
						<option @if(old("tag_id_3") == "2") selected @endif value="2">作曲</option>
						<option @if(old("tag_id_3") == "3") selected @endif value="3">編曲・アレンジ</option>
						<option @if(old("tag_id_3") == "4") selected @endif value="4">楽器・演奏</option>
						<option @if(old("tag_id_3") == "5") selected @endif value="5">レコーディング</option>
						<option @if(old("tag_id_3") == "6") selected @endif value="6">ミックスダウン</option>
						<option @if(old("tag_id_3") == "7") selected @endif value="7">マスタリング</option>
						<option @if(old("tag_id_3") == "8") selected @endif value="8">DAW・DTM全般</option>
						<option @if(old("tag_id_3") == "9") selected @endif value="9">その他</option>
					</select>

					@error('tag_id_3')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>

			<div class="form-group row mb-0">
				<div class="col-md-6 offset-md-4">
					<button type="submit" class="btn btn-primary">
						{{ __('確認') }}
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
@include('layouts.footer')