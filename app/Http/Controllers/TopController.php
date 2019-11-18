<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Exception;
use DateTime;
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
		try {
			// 質問リストの取得に必要な配列と変数
			$question_list = [];
			$tag_id = '';
			$keyword = '';
			$select_model = new TopSelectModel();

			// 質問リストを取得。取得エラーで戻り値が-1の時はエラーページを表示
			$select_count = $select_model->selectQuestions($question_list, $tag_id, $keyword);
			if ($select_count === -1) {
			}

			// 表示するために配列の追加、整理を行う
			foreach ($question_list as &$question) {
				// 回答数を取得
				$count_answer = $select_model->selectCountAnswers($question['question_id']);
				if ($count_answer === -1) {
				}
				// いいね数を取得
				$good_question = $select_model->selectCountGoodQuestions($question['question_id']);
				if ($good_question === -1) {
				}
				// 回答数といいね数を配列に格納
				$question['count_answer'] = $count_answer;
				$question['good_question'] = $good_question;
			}

			$select_model = null;

			$sort = 1;
			$data = $request->all();
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
			return view('index')->with([
				'question_list' => $result,
				'sort' => $sort
			]);
		} catch (\Exception $e) {
			echo 'ERROR';
		}
	}



	/**
	 * 質問リストの並べ替え
	 *
	 * @return Object
	 */
	public function sort(Request $request)
	{
		try {
			// 質問リストの取得に必要な配列と変数
			$question_list = [];
			$tag_id = '';
			$keyword = '';
			$select_model = new TopSelectModel();

			// 質問リストを取得。取得エラーで戻り値が-1の時はエラーページを表示
			$select_count = $select_model->selectQuestions($question_list, $tag_id, $keyword);
			if ($select_count === -1) {
			}

			// 表示するために配列の追加、整理を行う
			foreach ($question_list as &$question) {
				// 回答数を取得
				$count_answer = $select_model->selectCountAnswers($question['question_id']);
				if ($count_answer === -1) {
				}
				// いいね数を取得
				$good_question = $select_model->selectCountGoodQuestions($question['question_id']);
				if ($good_question === -1) {
				}
				// 回答数といいね数を配列に格納
				$question['count_answer'] = $count_answer;
				$question['good_question'] = $good_question;
			}

			$select_model = null;

			$sort = 1;
			$data = $request->all();
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
			return view('index')->with([
				'question_list' => $result,
				'sort' => $sort
			]);
		} catch (\Exception $e) {
			echo 'ERROR';
		}
	}
}
