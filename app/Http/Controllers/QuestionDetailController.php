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

class QuestionDetailController extends Controller
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
	 * 質問ページ表示
	 *
	 * @return View
	 */
	public function index($question_id)
	{
		print_r($question_id);
	}
}
