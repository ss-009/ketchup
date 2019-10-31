<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
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
	 * @return Array error : -1
	 */
	public function tagIdToTag(Int $tag_id) {

		$tag_list = [];
		$top_model = new TopSelectModel;

		$select_count = $top_model->selectTags($tag_list);
		if ($select_count === -1) {
			return -1;
		}

		foreach ($tag_list as $tag) {
			if ($tag['id'] === $tag_id) {
				return $tag;
			}
		}
		return -1;
	}

	/**
	 * タグテーブルIDをタグID、タグ名に置換
	 *
	 * @param Int
	 * @return String
	 */
	public function tagIdToName(Int $tag_id) {

		$tag_list = array(
			0 => NULL,
			1 => '作詞',
			2 => '作曲',
			3 => '編曲・アレンジ',
			4 => '楽器・演奏',
			5 => 'レコーディング',
			6 => 'ミックスダウン',
			7 => 'マスタリング',
			8 => 'DAW・DTM全般',
			9 => 'その他'
		);

		$tag_name = $tag_list[$tag_id];
		return $tag_name;
	}
}
