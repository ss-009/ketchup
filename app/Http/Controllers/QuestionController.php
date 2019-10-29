<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * 質問投稿ページ表示
	 *
	 * @return View
	 */
	public function index()
	{
		return view('question');
	}


	/**
	 * バリデーション、確認画面表示
	 *
	 * @return View
	 */
	public function question_confirm(Request $request) {

		$data = $request->all();
		
		// バリデーションチェック
		$request->validate([
		  'question_title' => 'required|min:5|max:30',
		  'question_content' => 'required|min:5|max:2000',
		  'tag_id_1' => 'not_in:0|max:1',
		  'tag_id_2' => 'in:tag_id_1',
		  'tag_id_3' => 'in:tag_id_1,tag_id_2'
		]);

		// 変数に格納
		$question_title = $data["question_title"];
		$question_content = $data["question_content"];
		$tag_id_1 = $data["tag_id_1"];
		$tag_id_2 = $data["tag_id_2"];
		$tag_id_3 = $data["tag_id_3"];

		// セッションに保存
		// $request->session()->put($question_title);
		// $request->session()->put($question_content);
		// $request->session()->put($tag_id_1);
		
		// ビューの表示
		return view('question_confirm')->with([
			"question_title" => $question_title,
			"question_content"  => $question_content,
			"tag_id_1"  => $tag_id_1,
			"tag_id_2"  => $tag_id_2,
			"tag_id_3"  => $tag_id_3
		]);
	}

	/**
	 * 質問投稿（登録処理）
	 *
	 * @param  array  $data
	 * @return 
	 */
	protected function insert(array $data)
	{
		return User::create([
			'user_id' => $data['user_id'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
			'score' => 0,
			'ip_address' => request()->ip(),
			'delete_flg' => 0,
		]);
	}
}
