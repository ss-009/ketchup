<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Models\QuestionDatailSelectModel;

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
}
