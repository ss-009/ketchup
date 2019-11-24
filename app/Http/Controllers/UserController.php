<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Exception;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Models\TopSelectModel;
use App\Http\Controllers\CommonController;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Http\Models\UserSelectModel;

class UserController extends Controller
{

	// 質問投稿、補足投稿用コントローラー

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
	 * ユーザーページ：質問リスト表示
	 * 
	 * @param Object $request
	 * @param Int $user_id
	 * @return View
	 */
	public function index(Request $request, $user_id)
	{
		// ユーザーの存在を確認
		$select_model = new UserSelectModel();
		$select_count = $select_model->checkUsers($user_id);
		if ($select_count !== 1) {
			return abort(404);
		}

		// 表示するリストを指定する
		$flg = 'q';
		$data = $request->all();
		if(isset($data['flg'])) {
			$flg = $data['flg'];
		}

		try {
			// ユーザー情報の取得に必要な配列と変数
			$user_data = [];
			// ユーザー情報を取得。取得エラーで戻り値が1以外の時はエラーページを表示
			$select_count = $select_model->selectUsers($user_data, $user_id, $flg);
			if ($select_count !== 1) {
				throw new Exception();
			}

			// 質問リストの取得に必要な配列と変数
			$question_list = [];

			if ($flg === 'a' || $flg === 'b') {
				// $flgがa,bのときは回答した質問リストを取得
				$select_count = $select_model->selectAnswersQuestions($question_list, $user_id, $flg);
			} else if($flg === 'q' || $flg == NULL) {
				// $flgがq,NULL以外のときは質問リストを取得
				$select_count = $select_model->selectQuestions($question_list, $user_id);
			} else {
				throw new Exception();
			}
			if ($select_count === -1) {
				throw new Exception();
			}

			$select_model = new TopSelectModel();

			// 表示するために配列の追加、整理を行う
			foreach ($question_list as &$question) {
				// 回答数を取得
				$count_answer = $select_model->selectCountAnswers($question['question_id']);
				if ($count_answer === -1) {
					throw new Exception();
				}
				// いいね数を取得
				$good_question = $select_model->selectCountGoodQuestions($question['question_id']);
				if ($good_question === -1) {
					throw new Exception();
				}
				// 回答数といいね数を配列に格納
				$question['count_answer'] = $count_answer;
				$question['good_question'] = $good_question;
			}
			$select_model = null;

			// ソートを指定する
			$sort = 1;
			if(isset($data['sort'])) {
				$sort = $data['sort'];
			}

			// 並べ替え指定時は抽出条件にする
			switch ($sort) {
				case 1:
					// 質問日時が新しい順（質問ID降順）
					$sort_key1 = array();
					foreach ($question_list as $key => $val) {
						$sort_key1[$key] = $val['question_id'];
					}
					array_multisort($sort_key1, SORT_DESC, $question_list);
					break;
				case 2:
					// 質問日時が古い順（質問ID昇順）
					$sort_key1 = array();
					foreach ($question_list as $key => $val) {
						$sort_key1[$key] = $val['question_id'];
					}
					array_multisort($sort_key1, SORT_ASC, $question_list);
					break;
				case 3:
					// 更新日時が新しい順（updated_at降順）
					$sort_key1 = $sort_key2 = array();
					foreach ($question_list as $key => $val) {
						$sort_key1[$key] = $val['updated_at'];
						$sort_key2[$key] = $key;
					}
					array_multisort($sort_key1, SORT_DESC, $sort_key2, SORT_DESC, $question_list);
					break;
				case 4:
					// 回答数が多い順（count_answer降順）
					$sort_key1 = $sort_key2 = array();
					foreach ($question_list as $key => $val) {
						$sort_key1[$key] = $val['count_answer'];
						$sort_key2[$key] = $key;
					}
					array_multisort($sort_key1, SORT_DESC, $sort_key2, SORT_DESC, $question_list);
					break;
				case 5:
					// 回答数が少ない順（count_answer昇順）
					$sort_key1 = $sort_key2 = array();
					foreach ($question_list as $key => $val) {
						$sort_key1[$key] = $val['count_answer'];
						$sort_key2[$key] = $key;
					}
					array_multisort($sort_key1, SORT_ASC, $sort_key2, SORT_DESC, $question_list);
					break;
				case 6:
					// いいねが多い順
					$sort_key1 = $sort_key2 = array();
					foreach ($question_list as $key => $val) {
						$sort_key1[$key] = $val['good_question'];
						$sort_key2[$key] = $key;
					}
					array_multisort($sort_key1, SORT_DESC, $sort_key2, SORT_DESC, $question_list);
					break;
				case 7:
					// PV数が多い順
					$sort_key1 = $sort_key2 = array();
					foreach ($question_list as $key => $val) {
						$sort_key1[$key] = $val['count_pv'];
						$sort_key2[$key] = $key;
					}
					array_multisort($sort_key1, SORT_DESC, $sort_key2, SORT_DESC, $question_list);
					break;
				default:
					throw new Exception();
			}

			// 質問日時のハイフンをスラッシュに置換
			foreach ($question_list as &$val) {
				$val['created_at'] = str_replace('-', '/', $val['created_at']);
			}

			// ページ番号と切り取り始める配列の番号を初期化
			$page = 1;
			if (isset($data['page'])) {
				$page = $data['page'];
			}
			$slice = 0;

			// ページ番号が1より大きい値の場合、切り取り始める配列の番号はページ番号*10-10とする
			if ($page > 1) {
				$slice = $page * 10 - 10;
			};

			// １ページに表示する配列の切り取り
			$question_slice = array_slice($question_list, $slice, 10);

			// ページネーションの設定
			$result = new LengthAwarePaginator(
				$question_slice,
				$select_count,
				10,
				$page,
				array('path' => $request->url())
			);

			// VIEWを返す
			return view('user')->with([
				'question_list' => $result,
				'sort' => $sort,
				'user_data' => $user_data,
			]);
		} catch (\Exception $e) {
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}
	}



	/**
	 * 質問投稿のバリデーション、確認画面表示
	 *
	 * @return View
	 */
	public function questionConfirm(Request $request) {

		// データ取得
		$data = $request->all();

		// 変数に格納
		$question_title = $data['question_title'];
		$question_content = $data['question_content'];
		$tag_id_1 = (int)$data['tag_id_1'];
		$tag_id_2 = (int)$data['tag_id_2'];
		$tag_id_3 = (int)$data['tag_id_3'];

		// バリデーションルール
		$rules = [	'question_title' => 'required|min:5|max:30',
					'question_content' => 'required|min:5|max:2000',
					'tag_id_1' => 'not_in:0|max:1'
		];

		// タグID_2が選択されていてタグID_1と同じ値の時にエラーメッセージ
		if ($tag_id_2 !== 0 && $tag_id_2 === $tag_id_1) {
			$rules['tag_id_2'] = new TagDuplicate();
		}

		// タグID_3が選択されていてタグID_2が未選択のときにエラーメッセージ
		if ($tag_id_3 !== 0 && $tag_id_2 === 0) {
			$rules['tag_id_3'] = new TagUnselected();
		// タグID_3が選択されていてタグID_1 or 2と同じ値の時にエラーメッセージ
		} else if ($tag_id_3 !== 0 && ($tag_id_3 === $tag_id_1 || $tag_id_3 === $tag_id_2)) {
			$rules['tag_id_3'] = new TagDuplicate();
		}
		
		// バリデーション
		$this->validate($request, $rules);

		// セッションに保存
		$request->session()->put('question_title', $question_title);
		$request->session()->put('question_content', $question_content);
		$request->session()->put('tag_id_1', $tag_id_1);
		$request->session()->put('tag_id_2', $tag_id_2);
		$request->session()->put('tag_id_3', $tag_id_3);

		// タグ名を取得
		$common_controller = new CommonController();
		$tag_name_1 = $common_controller->tagIdToName($tag_id_1);
		$tag_name_2 = $common_controller->tagIdToName($tag_id_2);
		$tag_name_3 = $common_controller->tagIdToName($tag_id_3);
		$common_controller = null;

		if($tag_name_1 === -1 || $tag_name_2 === -1 || $tag_name_3 === -1){
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}
		
		// ビューの表示
		return view('question_confirm')->with([
			'question_title' => $question_title,
			'question_content'  => $question_content,
			'tag_id_1'  => $tag_id_1,
			'tag_id_2'  => $tag_id_2,
			'tag_id_3'  => $tag_id_3,
			'tag_name_1'  => $tag_name_1,
			'tag_name_2'  => $tag_name_2,
			'tag_name_3'  => $tag_name_3
		]);
	}



	/**
	 * 質問投稿（登録処理）
	 *
	 * @param	Request $request
	 * @return	View
	 */
	protected function questionInsert(Request $request)
	{
		try {
			// セッションから値を取得
			$question_title = $request->session()->get('question_title');
			$question_content = $request->session()->get('question_content');
			$tag_table_id_1 = $request->session()->get('tag_id_1');
			$tag_table_id_2 = $request->session()->get('tag_id_2');
			$tag_table_id_3 = $request->session()->get('tag_id_3');

			// 登録に使うModelと値の設定
			$user_table_id = Auth::id();
			$date_time = date('Y/m/d H:i:s');
			$insert_model = new QuestionInsertModel();

			// 登録処理
			DB::beginTransaction();
			try {
				// 質問テーブルに登録
				$result = $insert_model->insertQuestions($question_title, $question_content, $user_table_id,
														$tag_table_id_1, $tag_table_id_2, $tag_table_id_3, $date_time);
				if ($result !== true) {
					throw new Exception();
				}
				
				// 最新の質問IDを取得
				$select_model = new QuestionDatailSelectModel();
				$question_id = $select_model->getLatestQuestionId();
				$select_model = null;
				if ($question_id === -1) {
					throw new Exception();
				}

				// PV数テーブルに登録
				$result = $insert_model->insertPvQuestions($question_id, $date_time);
				if ($result !== true) {
					throw new Exception();
				}

				// タグマップテーブルに登録
				$tag_id_list = array($tag_table_id_1, $tag_table_id_2, $tag_table_id_3);
				foreach ($tag_id_list as $tag_id) {
					if ($tag_id !== 0) {
						$result = $insert_model->insertTagMaps($question_id, $tag_id, $date_time);
						if ($result !== true) {
							throw new Exception();
						}
					}
				}
				$insert_model = null;

				// 正常登録時、二重投稿を防止しViewを表示
				$request->session()->regenerateToken();
				DB::commit();
				return view('question_complete')->with([
					'question_id' => $question_id,
				]);

			} catch (\Exception $e) {
				DB::rollback();
				throw new Exception();
			}
		} catch (\Exception $e) {
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}
	}



	/**
	 * 質問補足ページ表示
	 *
	 * @return View
	 */
	public function addition($question_id)
	{
		try {

			// 質問データの取得
			$question_data = [];
			$select_model = new QuestionDatailSelectModel();
			$select_count = $select_model->selectQuestionsData($question_data, $question_id);
			// 質問データ未取得の場合エラー表示
			if ($select_count === 0 || $select_count === -1) {
				return abort(404);
			}

			// ユーザーIDを取得
			$user_table_id = Auth::id();
			// 質問ユーザーか、補足済みではないか、終了済みではないかチェック
			if ($question_data[0]['user_table_id'] !== $user_table_id	||
				$question_data[0]['question_addition'] !== NULL			||
				$question_data[0]['close_flg'] !== 0					){
				throw new Exception();
			}

			// タグを取得
			$tag_list = [];
			$select_model = new QuestionDatailSelectModel();
			$select_count = $select_model->selectTags($tag_list);
			$select_model = null;
			if ($select_count === -1) {
				throw new Exception();
			}

			return view('addition')->with([
				'question_id' => $question_id,
				'question' => $question_data[0],
				'tag_list' => $tag_list,
			]);

		} catch (\Exception $e) {
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}	
	}



	/**
	 * 補足のバリデーション、確認画面表示
	 *
	 * @return View
	 */
	public function additionConfirm(Request $request) {

		// データ取得
		$data = $request->all();

		// question_idを取得
		$url = $_SERVER['REQUEST_URI'];
		$question_id = preg_replace('/[^0-9]/', '', $url);

		// 質問データの取得
		$question_data = [];
		$select_model = new QuestionDatailSelectModel();
		$select_count = $select_model->selectQuestionsData($question_data, $question_id);
		$select_model = null;
		// 質問データ未取得の場合エラー表示
		if ($select_count === 0 || $select_count === -1) {
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}

		// ユーザーIDを取得
		$user_table_id = Auth::id();
		// 質問ユーザーか、補足済みではないか、終了済みではないかチェック
		if ($question_data[0]['user_table_id'] !== $user_table_id	||
			$question_data[0]['question_addition'] !== NULL			||
			$question_data[0]['close_flg'] !== 0					){
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}

		// 変数に格納
		$question_title = $question_data[0]['question_title'];
		$question_content = $question_data[0]['question_content'];
		$question_addition = $data['question_addition'];
		$tag_id_1 = (int)$data['tag_id_1'];
		$tag_id_2 = (int)$data['tag_id_2'];
		$tag_id_3 = (int)$data['tag_id_3'];
		$created_at = $question_data[0]['created_at'];

		// バリデーションルール
		$rules = [	'question_addition' => 'required|min:5|max:1000',
					'tag_id_1' => 'not_in:0|max:1'
		];

		// タグID_2が選択されていてタグID_1と同じ値の時にエラーメッセージ
		if ($tag_id_2 !== 0 && $tag_id_2 === $tag_id_1) {
			$rules['tag_id_2'] = new TagDuplicate();
		}

		// タグID_3が選択されていてタグID_2が未選択のときにエラーメッセージ
		if ($tag_id_3 !== 0 && $tag_id_2 === 0) {
			$rules['tag_id_3'] = new TagUnselected();
		// タグID_3が選択されていてタグID_1 or 2と同じ値の時にエラーメッセージ
		} else if ($tag_id_3 !== 0 && ($tag_id_3 === $tag_id_1 || $tag_id_3 === $tag_id_2)) {
			$rules['tag_id_3'] = new TagDuplicate();
		}
		
		// バリデーション
		$this->validate($request, $rules);

		// セッションに保存
		$request->session()->put('question_addition', $question_addition);
		$request->session()->put('tag_id_1', $tag_id_1);
		$request->session()->put('tag_id_2', $tag_id_2);
		$request->session()->put('tag_id_3', $tag_id_3);

		// タグ名を取得
		$common_controller = new CommonController();
		$tag_name_1 = $common_controller->tagIdToName($tag_id_1);
		$tag_name_2 = $common_controller->tagIdToName($tag_id_2);
		$tag_name_3 = $common_controller->tagIdToName($tag_id_3);
		$common_controller = null;

		if($tag_name_1 === -1 || $tag_name_2 === -1 || $tag_name_3 === -1){
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}
		
		// ビューの表示
		return view('addition_confirm')->with([
			'question_title' => $question_title,
			'question_content' => $question_content,
			'question_addition' => $question_addition,
			'tag_id_1' => $tag_id_1,
			'tag_id_2' => $tag_id_2,
			'tag_id_3' => $tag_id_3,
			'tag_name_1' => $tag_name_1,
			'tag_name_2' => $tag_name_2,
			'tag_name_3' => $tag_name_3,
			'created_at' => $created_at
		]);
	}



	/**
	 * 補足の投稿（更新処理）
	 *
	 * @param	Request $request
	 * @return	View
	 */
	protected function additionUpdate(Request $request)
	{
		try {
			// セッションから値を取得
			$question_addition = $request->session()->get('question_addition');
			$tag_table_id_1 = $request->session()->get('tag_id_1');
			$tag_table_id_2 = $request->session()->get('tag_id_2');
			$tag_table_id_3 = $request->session()->get('tag_id_3');

			// question_idを取得
			$url = $_SERVER['REQUEST_URI'];
			$question_id = preg_replace('/[^0-9]/', '', $url);

			// 質問データの取得
			$question_data = [];
			$select_model = new QuestionDatailSelectModel();
			$select_count = $select_model->selectQuestionsData($question_data, $question_id);
			// 質問データ未取得の場合エラー
			if ($select_count !== 1) {
				throw new Exception();
			}

			// ユーザーIDを取得
			$user_table_id = Auth::id();
			// 質問ユーザーか、補足済みではないか、終了済みではないかチェック
			if ($question_data[0]['user_table_id'] !== $user_table_id	||
				$question_data[0]['question_addition'] !== NULL			||
				$question_data[0]['close_flg'] !== 0					){
				throw new Exception();
			}

			// 更新に使うModelと値の設定
			$last_comment = '';
			$date_time = date('Y/m/d H:i:s');
			$update_model = new QuestionDatailUpdateModel();

			// 更新処理
			DB::beginTransaction();
			try {
				// 質問補足の登録（更新処理）
				$update_count = $update_model->updateQuestions($question_id, $question_addition, $user_table_id,
										$tag_table_id_1, $tag_table_id_2, $tag_table_id_3, $last_comment, $date_time);
				$update_model = null;
				if ($update_count !== 1) {
					throw new Exception();
				}

				// 指定のタグマップを削除
				$delete_model = new QuestionDatailDeleteModel;
				$delete_count = $delete_model->deleteTagMaps($question_id);
				$delete_model = null;
				if ($delete_count < 1) {
					throw new Exception();
				}

				// タグマップテーブルに登録
				$insert_model = new QuestionInsertModel();
				$tag_id_list = array($tag_table_id_1, $tag_table_id_2, $tag_table_id_3);
				foreach ($tag_id_list as $tag_id) {
					if ($tag_id !== 0) {
						$result = $insert_model->insertTagMaps($question_id, $tag_id, $date_time);
						if ($result !== true) {
							throw new Exception();
						}
					}
				}
				$insert_model = null;

				// 正常登録時、二重投稿を防止しViewを表示
				DB::commit();
				$request->session()->regenerateToken();
				return view('addition_complete')->with([
					'question_id' => $question_id,
				]);

			} catch (\Exception $e) {
				DB::rollback();
				throw new Exception();
			}
		} catch (\Exception $e) {
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}
	}
}
