@section('title', 'Ketchup')
@section('description', 'Ketchupは音楽制作者のためのQ&Aサイトです。 作詞・作曲から編曲・DAW操作までDTMや曲作りに関する悩みを解決しましょう。')

@section('pageCss')
<link href="{{ asset('css/common.css') }}" rel="stylesheet">
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
<link href="{{ asset('css/question_detail.css') }}" rel="stylesheet">
<link href="{{ asset('css/question.css') }}" rel="stylesheet">
@endsection

@include('layouts.head')

<div class="card">
	<div class="content-confirm form-m">
		<div class="content-header">{{ __('質問の補足') }}</div>
		<form method="POST" action="addition/confirm">
			@csrf

			<div class="form-group row">
				<label for="question_title" class="col-md-4 col-form-label text-md-right">{{ __('質問タイトル') }}：</label>

				<div class="col-md-6">
					<input id="question_title" type="text" class="form-control" name="question_title" value="{{$question['question_title']}}" readonly>
				</div>
			</div>

			<div class="form-group row">
				<label for="question_content" class="col-md-4 col-form-label text-md-right">{{ __('質問本文') }}：</label>

				<div class="col-md-6">
					<textarea id="question_content" type="text" class="form-control" name="question_content" readonly>{{$question['question_content']}}</textarea>
				</div>
			</div>

			<div class="form-group row">
				<label for="question_addition" class="col-md-4 col-form-label text-md-right"><span class="required">※</span>{{ __('補足内容') }}：</label>

				<div class="col-md-6">
					<textarea id="question_addition" type="text" class="form-control @error('question_addition') is-invalid @enderror" name="question_addition" placeholder="5文字以上1000文字以下" maxlength="1000" required>{{ old('question_addition') }}</textarea>

					@error('question_addition')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>

			<div class="form-group row">
				<label for="tag_id_1" class="col-md-4 col-form-label text-md-right"><span class="required">※</span>{{ __('タグ1') }}：</label>
				<div class="dropdown col-md-6">
					<select class="form-control @error('tag_id_1') is-invalid @enderror" name="tag_id_1" id="tag_id_1">
						<option @if(old("tag_id_1") == "0") selected @endif value="0">タグを選択</option>
						@foreach($tag_list as $tag)
						<option @if(old("tag_id_1", $question['tag_table_id_1']) == $tag['id']) selected @endif value={{$tag['id']}}>{{$tag['tag_name']}}</option>
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
			<label for="tag_id_2" class="col-md-4 col-form-label text-md-right">{{ __('タグ2') }}：</label>
				<div class="dropdown col-md-6">
					<select class="form-control @error('tag_id_2') is-invalid @enderror" name="tag_id_2" id="tag_id_2">
						<option @if(old("tag_id_2") == "0") selected @endif value="0">タグを選択</option>
						@foreach($tag_list as $tag)
						<option @if(old("tag_id_2", $question['tag_table_id_2']) == $tag['id']) selected @endif value={{$tag['id']}}>{{$tag['tag_name']}}</option>
						@endforeach
					</select>

					@error('tag_id_2')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>

			<div class="form-group row">
			<label for="tag_id_3" class="col-md-4 col-form-label text-md-right">{{ __('タグ3') }}：</label>
				<div class="dropdown col-md-6">
					<select class="form-control @error('tag_id_3') is-invalid @enderror" name="tag_id_3" id="tag_id_3">
						<option @if(old("tag_id_3") == "0") selected @endif value="0">タグを選択</option>
						@foreach($tag_list as $tag)
						<option @if(old("tag_id_3", $question['tag_table_id_3']) == $tag['id']) selected @endif value={{$tag['id']}}>{{$tag['tag_name']}}</option>
						@endforeach
					</select>

					@error('tag_id_3')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>

			<div>
				<div class="btn-confirm">
					<a href="/question/{{$question_id}}"><button type="button" class="btn btn-outline-secondary">{{ __('戻る') }}</button></a>
					<button type="submit" class="btn btn-outline-danger">{{ __('確認') }}</button>
				</div>
			</div>
		</form>
	</div>
</div>
@include('layouts.footer')