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
	<div class="content-confirm">
		<div class="content-header">補足の投稿が完了しました。</div>
		<div class="content-body"><a href="/question/{{$question_id}}" id="question_url">3秒後に質問ページに遷移します。</a></div>
	</div>
</div>
@section('pageJs')
<script src="{{ asset('js/question_post.js') }}"></script>
@endsection('pageJs')
@include('layouts.footer')