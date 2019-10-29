@section('title', 'Ketchup')
@section('description', 'Ketchupは音楽制作者のためのQ&Aサイトです。 作詞・作曲から編曲・DAW操作までDTMや曲作りに関する悩みを解決しましょう。')

@section('pageCss')
<link href="{{ asset('css/question.css') }}" rel="stylesheet">
@endsection

@include('layouts.head')

<div class="card">
	<div class="card-header">{{ __('質問投稿完了') }}</div>

	<div class="card-body">
		質問の投稿が完了しました。
	</div>
</div>
@include('layouts.footer')