<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Models\QuestionDatailSelectModel;
use App\Http\Models\TopSelectModel;

class CommonController extends Controller
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
	 * タグテーブルIDをタグID、タグ名に置換
	 *
	 * @param Int
	 * @return String
	 */
	public function tagIdToName(Int $tag_id) {

		try {
			$tag_list = [];
			$select_model = new QuestionDatailSelectModel();
			$select_count = $select_model->selectTags($tag_list);
			$select_model = null;
			
			if ($select_count === -1) {
				throw new Exception();
			}

			$tag_name = '';

			foreach ($tag_list as $tag) {
				if ($tag['id'] === $tag_id) {
					$tag_name = $tag['tag_name'];
				}
			}

			return $tag_name;

		} catch (\Exception $e) {
			return -1;
		}
	}

	/**
	 * タグランキングを取得
	 *
	 * @param Array データ格納用配列
	 * @return Int  1 : 正常、-1 : エラー
	 */
	public function getTagRanking(&$ranking_tag_list) {
		try {
			$select_model = new TopSelectModel();
			// タグランキングを取得する
			$ranking_tag_list = [];
			$select_count = $select_model->selectTagsCount($ranking_tag_list);
			if ($select_count === -1) {
				throw new Exception();
			}
			// タグIDとタグ名を取得する
			foreach($ranking_tag_list as &$tag) {
				$tag_data = [];
				$select_count = $select_model->selectTagIdName($tag_data, $tag['tag_table_id']);
				if ($select_count === 1) {
					$tag['tag_id'] = $tag_data[0]['tag_id'];
					$tag['tag_name'] = $tag_data[0]['tag_name'];
				} else {
					throw new Exception();
				}
			}
			return 1;

		} catch (\Exception $e) {
			return -1;
		}
	}
}
