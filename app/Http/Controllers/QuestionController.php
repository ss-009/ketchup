<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Validator;
use App\Rules\TagDuplicate;
use App\Rules\TagUnselected;
use App\Http\Models\QuestionInsertModel;
use App\Http\Models\QuestionDatailSelectModel;
use App\Http\Models\QuestionDatailUpdateModel;
use App\Http\Models\QuestionDatailDeleteModel;

class QuestionController extends Controller
{

	// 質問投稿、補足投稿用コントローラー

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
		try {
			$tag_list = [];
			$select_model = new QuestionDatailSelectModel();
			$select_count = $select_model->selectTags($tag_list);
			$select_model = null;
			
			if ($select_count === -1) {
				throw new Exception();
			}

			return view('question')->with([
				'tag_list' => $tag_list
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
				return view('question_complete');

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
			'tag_name_3' => $tag_name_3
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
				return view('addition_complete');

			} catch (\Exception $e) {
				DB::rollback();
				throw new Exception();
			}
		} catch (\Exception $e) {
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}
	}
}
