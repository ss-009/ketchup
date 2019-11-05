<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\QuestionDatailSelectModel;
use App\Http\Models\QuestionDatailInsertModel;

class QuestionDetailController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
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

		// 回答データの取得
		$answer_data = [];
		$order_by = 'DESC';
		$count_answer = $select_model->selectAnswers($answer_data, $question_id, $order_by);
		// 質問データ未取得の場合エラー表示
		if ($count_answer === -1) {
			return 'ERROR PAGE';
		}

		// レスを取得する
		// 回答データの配列に、回答ごとにレスを追加する

		// 質問者か、回答済か、その他か判定する

		
		return view('question_detail')->with([
			'question_id' => $question_id,
			'question' => $question_data[0],
			'answer_data' => $answer_data,
			'count_answer' => $count_answer,
		]);
	}

	/**
	 * 回答する
	 *
	 * @return View
	 */
	public function answer(Request $request)
	{
		// データ取得
		$data = $request->all();

		// 変数に格納
		$question_id = $data['question_id'];
		$answer_content = $data['answer_content'];

		// 登録に使うModelと値の設定
		$insert_model = new QuestionDatailInsertModel;
		$user_table_id = Auth::id();
		$date_time = date('Y/m/d H:i:s');

		// 登録処理
		DB::beginTransaction();
		try {
			$result = $insert_model->insertAnswers($question_id, $answer_content, $user_table_id, $date_time);
			$insert_model = null;

			// 正常登録時、二重投稿を防止しViewを表示
			if ($result === true) {
				DB::commit();
				return redirect()->action('QuestionDetailController@index', ['question_id' => $question_id]);
			} else {
				throw new Exception();
			}

		} catch (\Exception $e) {
			DB::rollback();
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}
	}
}
