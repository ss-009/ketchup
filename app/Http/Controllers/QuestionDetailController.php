<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\QuestionDatailSelectModel;

class QuestionDetailController extends Controller
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
	 * 質問ページ表示
	 *
	 * @return View
	 */
	public function index($question_id)
	{
		// 質問データの取得
		$question_data = [];
		$select_model = new QuestionDatailSelectModel;
		$select_count = $select_model->selectQuestionsData($question_data, $question_id);
		// 質問データ未取得の場合エラー表示
		if ($select_count === 0 || $select_count === -1) {
			return 'ERROR PAGE';
		}

		return view('question_detail')->with([
			'question' => $question_data[0]
		]);
	}
}
