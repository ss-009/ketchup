<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Exception;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\QuestionDatailSelectModel;
use App\Http\Models\QuestionDatailInsertModel;
use App\Http\Models\QuestionDatailUpdateModel;
use App\Http\Models\QuestionDatailDeleteModel;

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
			$select_model = new QuestionDatailSelectModel();
			$select_count = $select_model->selectQuestionsData($question_data, $question_id);
			// 質問データ未取得の場合エラー表示（後ほど404エラーページを出力する）
			if ($select_count === 0 || $select_count === -1) {
				throw new Exception();
			}

			// いいね数を取得
			$count_good_quesiton = $select_model->selectCountGoodQuestions($question_id);
			// データ取得時エラーの場合
			if ($count_good_quesiton === -1) {
				throw new Exception();
			}

			// 回答データの取得
			$answer_data = [];
			$order_by = 'DESC';
			$count_answer = $select_model->selectAnswers($answer_data, $question_id, $order_by);
			// データ取得時エラーの場合
			if ($count_answer === -1) {
				throw new Exception();
			}

			// レスを取得し、回答データの配列にレスを追加する
			$order_by = '';
			foreach ($answer_data as &$answer) {
				$reply_count = $select_model->selectReplys($answer['reply_data'], $question_id, $answer['answer_id'], $order_by);
				$answer['count_good_answer'] = $select_model->selectCountGoodAnswers($answer['answer_id']);
				// 返信データ取得時エラーの場合
				if ($reply_count === -1) {
					throw new Exception();
				}
			}
			$select_model = null;

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
					foreach ($answer_data as $data) {
						if ($data['user_table_id'] === $user_table_id) {
							$user_type = 'respondent';
							break;
						}
					}
				}
			}

			// 最終アクセスのIPアドレス
			$ip_address = $question_data[0]['end_ip_address'];
			// アクセスしたIPアドレスを取得
			$now_ip_address = request()->ip();
			// 最終更新日時から＋60秒の日時を取得
			$pv_after_60 = (new DateTime($question_data[0]['pv_updated_at']))->modify('+60 second');
			// 現在日時
			$date_time = new DateTime();

			// 同一IPではない場合、または同一IPでも60秒（1分）経っていたら更新
			if ($ip_address !== $now_ip_address ||
			   ($ip_address === $now_ip_address && $date_time >= $pv_after_60)) {

				// 更新に使うModelの設定
				$update_model = new QuestionDatailUpdateModel();
				
				// 更新処理
				DB::beginTransaction();
				try {
					// 質問の終了処理
					$result = $update_model->updatePvQuestionMaps($question_id, $now_ip_address, $date_time);
					$update_model = null;
					// 正常時はコミット
					if ($result === 1) {
						DB::commit();

					} else {
						throw new Exception();
					}
				} catch (\Exception $e) {
					DB::rollback();
					throw new Exception();
				}
			}

			return view('question_detail')->with([
				'question_id' => $question_id,
				'question' => $question_data[0],
				'answer_data' => $answer_data,
				'count_answer' => $count_answer,
				'user_type' => $user_type,
				'count_good_quesiton' => $count_good_quesiton
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

			// 質問の存在チェック
			$select_model = new QuestionDatailSelectModel();
			$select_count = $select_model->checkQuestions($question_id);
			if ($select_count !== 1) {
				throw new Exception();
			}

			// 回答一覧を取得する
			$answer_data = [];
			$order_by = '';
			$select_count = $select_model->selectAnswers($answer_data, $question_id, $order_by);
			$select_model = null;
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

			// 登録に使う値とModelの設定
			$date_time = date('Y/m/d H:i:s');
			$insert_model = new QuestionDatailInsertModel();

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

			// 質問の存在チェック
			$select_model = new QuestionDatailSelectModel();
			$select_count = $select_model->checkQuestions($question_id);
			if ($select_count !== 1) {
				throw new Exception();
			}

			// 回答の存在チェック
			$select_model = new QuestionDatailSelectModel();
			$select_count = $select_model->checkAnswers($question_id, $answer_id);
			$select_model = null;
			if ($select_count !== 1) {
				throw new Exception();
			}

			// 登録に使う値とModelの設定
			$user_table_id = Auth::id();
			$date_time = date('Y/m/d H:i:s');
			$insert_model = new QuestionDatailInsertModel();

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



	/**
	 * ベストアンサーを選択
	 *
	 * @return View
	 */
	public function bestAnswer(Request $request)
	{
		try {
			// データ取得
			$data = $request->all();

			// 変数に格納
			$question_id = $data['question_id'];
			$page_id = $data['page_id'];
			$best_answer_id = $data['best_answer_id'];
			$last_comment = $data['last_comment'];

			// 改ざんチェック
			if ($question_id !== $page_id) {
				throw new Exception();
			}

			// 質問の存在チェック
			$select_model = new QuestionDatailSelectModel();
			$select_count = $select_model->checkQuestions($question_id);
			if ($select_count !== 1) {
				throw new Exception();
			}

			// 回答の存在チェック
			$select_model = new QuestionDatailSelectModel();
			$select_count = $select_model->checkAnswers($question_id, $best_answer_id);
			$select_model = null;
			if ($select_count !== 1) {
				throw new Exception();
			}

			// 更新に使う値とModelの設定
			$user_table_id = Auth::id();
			$date_time = date('Y/m/d H:i:s');
			$update_model = new QuestionDatailUpdateModel();
			
			// 更新処理
			DB::beginTransaction();
			try {

				// 質問の終了処理
				$result = $update_model->updateCloseFlgQuestions($question_id, $user_table_id, $last_comment, $date_time);

				// 正常時は回答のベストアンサー処理
				if ($result === 1) {
					$result = $update_model->updateBestAnswers($best_answer_id, $date_time);
					$update_model = null;

					// 正常時はコミットしてリダイレクト
					if ($result === 1) {
						$request->session()->regenerateToken();
						DB::commit();
						return redirect()->action('QuestionDetailController@index', ['question_id' => $question_id]);

					} else {
						throw new Exception();
					}
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
	 * 質問にいいねをする、いいねを削除する
	 *
	 * @return View
	 */
	public function goodQuestion(Request $request) {
		try {
			// 値を変数に格納
			$question_id = $request->input('question_id');
			$user_table_id = Auth::id();
			$date_time = date('Y/m/d H:i:s');

			$user_status = '';
			DB::beginTransaction();

			// いいねしているか確認
			$select_model = new QuestionDatailSelectModel();
			$select_count = $select_model->checkGoodQuestions($question_id, $user_table_id);

			if ($select_count === -1) {
				throw new Exception();
			} else if ($select_count === 0) {
				// 登録していない場合登録
				$insert_model = new QuestionDatailInsertModel();
				$result = $insert_model->insertGoodQuestionMaps($question_id, $user_table_id, $date_time);
				$insert_model = null;
				if ($result !== true) {
					throw new Exception();
				}
				$user_status = 1;
			} else {
				// 登録されている場合削除
				$delete_model = new QuestionDatailDeleteModel();
				$delete_count = $delete_model->deleteGoodQuestionMaps($question_id, $user_table_id);
				$delete_model = null;
				if ($delete_count < 1) {
					throw new Exception();
				}
				$user_status = 0;
			}

			DB::commit();

			// いいね数をカウントする
			$select_count = $select_model->selectCountGoodQuestions($question_id);
			if($select_count === -1) {
				throw new Exception();
			}
			$select_model = null;

			// 戻り値を設定してJSONで返す
			$return_data = array(	'status_code'	=> 200,
									'user_status'	=> $user_status,
									'good_count'	=> $select_count
			);
			$return_json = json_encode($return_data);
			return $return_json;

		} catch (\Exception $e) {
			DB::rollback();

			$return_data = array('status_code'	=> 500);
			$return_json = json_encode($return_data);
			return $return_json;
		}
	}
}
