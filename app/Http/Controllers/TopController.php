<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use App\Http\Models\TopSelectModel;
use Illuminate\Pagination\LengthAwarePaginator;

class TopController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * TOPページ表示
	 *
	 * @return View
	 */
	public function index(Request $request)
	{
		// 質問リストの取得に必要な配列と変数
		$question_list = [];
		$tag_id = '';
		$keyword = '';
		$top_model = new TopSelectModel;

		// 質問リストを取得。取得エラーで戻り値が-1の時はエラーページを表示
		$select_count = $top_model->selectQuestions($question_list, $tag_id, $keyword);
		if ($select_count === -1) {
		}

		// 表示するために配列の追加、整理を行う
		foreach ($question_list as &$question) {
			// 回答数を取得
			$count_answer = $top_model->selectCountAnswers($question['question_id']);
			if ($count_answer === -1) {
			}
			// いいね数を取得
			$good_question = $top_model->selectCountGoodQuestions($question['question_id']);
			if ($good_question === -1) {
			}
			// 回答数といいね数を配列に格納
			$question['count_answer'] = $count_answer;
			$question['good_question'] = $good_question;
		}

		// ページ番号と切り取り始める配列の番号を初期化
		$page_num = $request->page;
		$slice = 0;

		// ページ番号が1より大きい値の場合、切り取り始める配列の番号はページ番号*10-10とする
		if ($page_num > 1) {
			$slice = $page_num * 10 - 10;
		};

		// １ページに表示する配列の切り取り
		$question_top = array_slice($question_list, $slice, 10);

		// ページネーションの設定
		$result = new LengthAwarePaginator(
			$question_top,
			$select_count,
			10,
			$request->page,
			array('path' => $request->url())
		);
		
		// VIEWを返す
		return view('index')->with([
			'question_list' => $result
		]);
	}
}
