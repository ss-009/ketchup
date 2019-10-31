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
			$rules['tag_id_2'] = new TagDuplicate;
		}

		// タグID_3が選択されていてタグID_2が未選択のときにエラーメッセージ
		if ($tag_id_3 !== 0 && $tag_id_2 === 0) {
			$rules['tag_id_3'] = new TagUnselected;
		// タグID_3が選択されていてタグID_1 or 2と同じ値の時にエラーメッセージ
		} else if ($tag_id_3 !== 0 && ($tag_id_3 === $tag_id_1 || $tag_id_3 === $tag_id_2)) {
			$rules['tag_id_3'] = new TagDuplicate;
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
		$common_controller = new CommonController;
		$tag_name_1 = $common_controller->tagIdToName($tag_id_1);
		$tag_name_2 = $common_controller->tagIdToName($tag_id_2);
		$tag_name_3 = $common_controller->tagIdToName($tag_id_3);
		
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
		// セッションから値を取得
		$question_title = $request->session()->get('question_title');
		$question_content = $request->session()->get('question_content');
		$tag_id_1 = $request->session()->get('tag_id_1');
		$tag_id_2 = $request->session()->get('tag_id_2');
		$tag_id_3 = $request->session()->get('tag_id_3');

		// 登録に使うModelと値の設定
		$insert_model = new QuestionInsertModel;
		$user_table_id = Auth::id();
		$date_time = date('Y/m/d H:i:s');

		// 登録処理
		DB::beginTransaction();
		try {
			$result = $insert_model->insertQuestions($question_title, $question_content, $user_table_id,
													$tag_id_1, $tag_id_2, $tag_id_3, $date_time);
			$insert_model = null;

			// 正常登録時、二重投稿を防止しViewを表示
			if ($result === true) {
				DB::commit();
				$request->session()->regenerateToken();
				return view('question_complete');
			} else {
				throw new Exception();
			}

		} catch (\Exception $e) {
			DB::rollback();
			echo '<script type="text/javascript">alert("エラーが発生しました。");window.history.back(-2)</script>';
		}
	}
}
