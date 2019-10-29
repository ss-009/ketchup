<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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
	 * タグIDをタグ名に置換
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
