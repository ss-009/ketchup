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
		try {
			// 質問データの取得
			$question_data = [];
			$select_model = new QuestionDatailSelectModel;
			$select_count = $select_model->selectQuestionsData($question_data, $question_id);
			// 質問データ未取得の場合エラー表示（後ほど404エラーページを出力する）
			if ($select_count === 0 || $select_count === -1) {
				throw new Exception();
			}

			// 回答データの取得
			$answer_data = [];
			$order_by = 'DESC';
			$count_answer = $select_model->selectAnswers($answer_data, $question_id, $order_by);
			// 回答データ取得時エラーの場合
			if ($count_answer === -1) {
				throw new Exception();
			}

			// レスを取得し、回答データの配列にレスを追加する
			$order_by = '';
			foreach ($answer_data as &$answer) {
				$reply_count = $select_model->selectReplys($answer['reply_data'], $question_id, $answer['answer_id'], $order_by);
				// 返信データ取得時エラーの場合
				if ($reply_count === -1) {
					throw new Exception();
				}
			}

			// ユーザータイプを判定する
			$user_type = 'logout';

			// ログイン済みかチェック
			if (Auth::check()) {
				$user_table_id = Auth::id();
				$user_type = 'login';

				// 質問者かチェック
				if ($question_data[0]['user_table_id'] === $user_table_id) {
					$user_type = 'questioner';
				
				// 質問に回答済みかチェック
				} else {
					foreach ($answer_data as $answer) {
						if ($answer['user_table_id'] === $user_table_id) {
							$user_type = 'respondent';
						}
					}
				}
			}

			return view('question_detail')->with([
				'question_id' => $question_id,
				'question' => $question_data[0],
				'answer_data' => $answer_data,
				'count_answer' => $count_answer,
				'user_type' => $user_type
			]);

		} catch (\Exception $e) {
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}
	}

	/**
	 * 回答する
	 *
	 * @return View
	 */
	public function answer(Request $request)
	{
		try {
			// データ取得
			$data = $request->all();

			// 変数に格納
			$question_id = $data['question_id'];
			$page_id = $data['page_id'];
			$answer_content = $data['answer_content'];

			// 改ざんチェック
			if ($question_id !== $page_id) {
				throw new Exception();
			}

			// 回答一覧を取得する
			$answer_data = [];
			$order_by = '';
			$select_model = new QuestionDatailSelectModel;
			$select_count = $select_model->selectAnswers($answer_data, $question_id, $order_by);
			if ($select_count === -1) {
				throw new Exception();
			}

			// 既に回答済みでないかチェックを行う
			$user_table_id = Auth::id();
			foreach ($answer_data as $answer) {
				if ($answer['user_table_id'] === $user_table_id) {
					throw new Exception();
				}
			}

			// 登録に使うModelと値の設定
			$insert_model = new QuestionDatailInsertModel;
			$date_time = date('Y/m/d H:i:s');

			// 登録処理
			DB::beginTransaction();
			try {
				$result = $insert_model->insertAnswers($question_id, $answer_content, $user_table_id, $date_time);
				$insert_model = null;

				// 正常登録時、二重投稿を防止しViewを表示
				if ($result === true) {
					$request->session()->regenerateToken();
					DB::commit();
					return redirect()->action('QuestionDetailController@index', ['question_id' => $question_id]);
				} else {
					throw new Exception();
				}

			} catch (\Exception $e) {
				DB::rollback();
				throw new Exception();
			}

		} catch (\Exception $e) {
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}
	}


	/**
	 * 返信（レス）をする
	 *
	 * @return View
	 */
	public function reply(Request $request)
	{
		try {
			// データ取得
			$data = $request->all();

			// 変数に格納
			$question_id = $data['question_id'];
			$page_id = $data['page_id'];
			$answer_id = $data['answer_id'];
			$reply_content = $data['reply_content'];

			// 改ざんチェック
			if ($question_id !== $page_id) {
				throw new Exception();
			}

			// 回答の存在チェック
			$select_model = new QuestionDatailSelectModel;
			$select_count = $select_model->checkAnswers($question_id, $answer_id);
			$select_model = null;
			if ($select_count !== 1) {
				throw new Exception();
			}

			// 登録に使うModelと値の設定
			$insert_model = new QuestionDatailInsertModel;
			$user_table_id = Auth::id();
			$date_time = date('Y/m/d H:i:s');

			// 登録処理
			DB::beginTransaction();
			try {
				$result = $insert_model->insertReplys($question_id, $answer_id, $reply_content, $user_table_id, $date_time);
				$insert_model = null;

				// 正常登録時、二重投稿を防止しViewを表示
				if ($result === true) {
					$request->session()->regenerateToken();
					DB::commit();
					return redirect()->action('QuestionDetailController@index', ['question_id' => $question_id]);
				} else {
					throw new Exception();
				}

			} catch (\Exception $e) {
				DB::rollback();
				throw new Exception();
			}

		} catch (\Exception $e) {
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}
	}
}
