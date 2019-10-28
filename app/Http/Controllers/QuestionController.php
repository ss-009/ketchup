<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Article;

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
	public function confirm(Request $request) {
		//入力値の取得
		$article = new Article($request->all());
		
		//入力チェック
		$this->validate($request, [
		  'question_title' => 'required|min:5|max:30',
		  'question_content' => 'required|min:5|max:2000',
		  'tag1' => 'not_in: 0'
		]);
		
		//セッションに保存
		$request->session()->put('article', $article);
		
		//ビューの表示
		return view('confirm', compact('article'));
	}

	/**
	 * 質問投稿のバリデーション
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'user_id' => ['required', 'string', 'min:3', 'max:20', 'unique:users' ,'regex:/^[!-~]+$/'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:8'],
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
