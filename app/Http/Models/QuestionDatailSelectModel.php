<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionDatailSelectModel extends Model
{
	/**
	 * 質問ページの質問内容と件数を取得する
	 * 
	 * @param array $question_data 取得したデータを格納する配列
	 * @param string $question_id 指定の質問ID
	 * @return int $select_count 取得したデータの件数1を返す エラー時は-1を返す
	 */
	public function selectQuestionsData(&$question_data, $question_id)
	{
		// 質問IDがない場合は-1を返して処理終了
		if ($question_id == "") {
			return -1;
		}

		// データ格納用配列の初期化
		$question = [];

		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "questions.question_title AS question_title, ";
		$sql .= "questions.question_content AS question_content, ";
		$sql .= "questions.question_addition AS question_addition, ";
		$sql .= "questions.last_comment, ";
		$sql .= "questions.close_flg, ";
		$sql .= "questions.created_at, ";
		$sql .= "questions.updated_at, ";
		$sql .= "tag1.id AS tag_table_id_1, ";
		$sql .= "tag2.id AS tag_table_id_2, ";
		$sql .= "tag3.id AS tag_table_id_3, ";
		$sql .= "tag1.tag_id AS tag_id_1, ";
		$sql .= "tag2.tag_id AS tag_id_2, ";
		$sql .= "tag3.tag_id AS tag_id_3, ";
		$sql .= "tag1.tag_name AS tag_name_1, ";
		$sql .= "tag2.tag_name AS tag_name_2, ";
		$sql .= "tag3.tag_name AS tag_name_3, ";
		$sql .= "users.user_id, ";
		$sql .= "users.image, ";
		$sql .= "users.score ";
		$sql .= "FROM questions ";
		$sql .= "LEFT OUTER JOIN tags AS tag1 ";
		$sql .= "ON questions.tag_id_1 = tag1.id ";
		$sql .= "LEFT OUTER JOIN tags AS tag2 ";
		$sql .= "ON questions.tag_id_2 = tag2.id ";
		$sql .= "LEFT OUTER JOIN tags AS tag3 ";
		$sql .= "ON questions.tag_id_3 = tag3.id ";
		$sql .= "LEFT OUTER JOIN users ";
		$sql .= "ON questions.user_table_id = users.id ";
		$sql .= "WHERE ";
		$sql .= "users.id IS NOT NULL ";
		$sql .= "AND ";
		$sql .= "questions.delete_flg = 0 ";
		$sql .= "AND ";
		$sql .= "questions.id = :question_id ";
		$sql .= "LIMIT 1 ";

		// パラメータ設定
		$param = [];

		// bind値の設定
		$param["question_id"] = $question_id;

		try {
			// SQLを実行
			$result = DB::select($sql, $param);
			// オブジェクトを配列に変換して格納
			$question_data = json_decode(json_encode($result), true);
			// 取得した件数をカウント
			$select_count = count($question_data);
			// 取得したデータの件数を返す
			return $select_count;

		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}



	/**
	 * 質問のいいね数を取得する
	 * 
	 * @param string $question_id 質問のID
	 * @return int $select_count 取得したデータの件数を返す エラー時は-1を返す
	 */
	public function selectCountGoodQuestions($question_id)
	{
		// 質問IDがない場合は-1を返して処理終了
		if ($question_id == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "count(good_question_maps.id) AS count_good_question_maps_id ";
		$sql .= "FROM questions ";
		$sql .= "LEFT OUTER JOIN good_question_maps ";
		$sql .= "ON questions.id = good_question_maps.question_id ";
		$sql .= "WHERE ";
		$sql .= "good_question_maps.question_id IS NOT NULL ";
		$sql .= "AND ";
		$sql .= "questions.delete_flg = 0 ";
		$sql .= "AND ";
		$sql .= "questions.id = :question_id ";

		// パラメータ設定
		$param = [];
		$param["question_id"] = $question_id;

		try {
			// SQLを実行
			$result = DB::select($sql, $param);
			// オブジェクトからカウント件数を取得
			$select_count = $result[0]->count_good_question_maps_id;
			// 取得したカウント件数を返す
			return $select_count;

		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}



	/**
	 * 回答一覧と回答数を取得する
	 * 
	 * @param array $answer_data 取得したデータを格納する配列
	 * @param string $question_id 質問のID
	 * @param string $order_by DESC or ASC
	 * @return int $select_count 取得したデータの件数を返す エラー時は-1を返す
	 */
	public function selectAnswers(&$answer_data, $question_id, $order_by)
	{
		// 質問IDがない場合は-1を返して処理終了
		if ($question_id == "") {
			return -1;
		}

		// データ格納用配列の初期化
		$answer_data = [];

		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "answers.id AS id, ";
		$sql .= "answers.answer_content AS answer_content, ";
		$sql .= "answers.best_answer_flg AS best_answer_flg, ";
		$sql .= "answers.created_at AS created_at, ";
		$sql .= "answers.updated_at AS updated_at, ";
		$sql .= "users.user_id AS user_id, ";
		$sql .= "users.image AS image, ";
		$sql .= "users.score AS score ";
		$sql .= "FROM answers ";
		$sql .= "LEFT OUTER JOIN users ";
		$sql .= "ON answers.user_table_id = users.id ";
		$sql .= "WHERE ";
		$sql .= "users.id IS NOT NULL ";
		$sql .= "AND ";
		$sql .= "answers.delete_flg = 0 ";
		$sql .= "AND ";
		$sql .= "answers.question_id = :question_id ";

		// 並べ替え条件の追加
		if ($order_by !== "") {
			$sql .= "ORDER BY ";
			$sql .= "answers.updated_at ";
			$sql .= $order_by;
		}

		// パラメータ設定
		$param = [];
		$param["question_id"] = $question_id;

		try {
			// SQLを実行
			$result = DB::select($sql, $param);
			// オブジェクトを配列に変換して格納
			$answer_data = json_decode(json_encode($result), true);
			// 取得した件数をカウント
			$select_count = count($answer_data);
			// 取得したデータの件数を返す
			return $select_count;

		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}



	/**
	 * 回答のいいね数を取得する
	 * 
	 * @param string $answer_id 回答のID
	 * @return int $select_count 取得したデータの件数を返す エラー時は-1を返す
	 */
	public function selectCountGoodAnswers($answer_id)
	{
		// 質問IDがない場合は-1を返して処理終了
		if ($answer_id == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "count(good_answer_maps.id) AS count_good_answer_maps_id ";
		$sql .= "FROM answers ";
		$sql .= "LEFT OUTER JOIN good_answer_maps ";
		$sql .= "ON answers.id = good_answer_maps.answer_id ";
		$sql .= "WHERE ";
		$sql .= "good_answer_maps.answer_id IS NOT NULL ";
		$sql .= "AND ";
		$sql .= "answers.delete_flg = 0 ";
		$sql .= "AND ";
		$sql .= "answers.id = :answer_id ";

		// パラメータ設定
		$param = [];
		$param["answer_id"] = $answer_id;

		try {
			// SQLを実行
			$result = DB::select($sql, $param);
			// オブジェクトからカウント件数を取得
			$select_count = $result[0]->count_good_answer_maps_id;
			// 取得したカウント件数を返す
			return $select_count;

		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}



	/**
	 * 返信一覧と返信数を取得する
	 * 
	 * @param array $reply_data 取得したデータを格納する配列
	 * @param string $answer_id 回答のID
	 * @param string $order_by DESC or ASC
	 * @return int $select_count 取得したデータの件数を返す エラー時は-1を返す
	 */
	public function selectReplys(&$reply_data, $answer_id, $order_by)
	{
		
		// 回答IDがない場合は-1を返して処理終了
		if ($answer_id == "") {
			return -1;
		}

		// データ格納用配列の初期化
		$reply_data = [];

		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "replys.id AS id, ";
		$sql .= "replys.reply_content AS reply_content, ";
		$sql .= "replys.created_at AS created_at, ";
		$sql .= "users.user_id AS user_id, ";
		$sql .= "users.image AS image, ";
		$sql .= "users.score AS score ";
		$sql .= "FROM answers ";
		$sql .= "LEFT OUTER JOIN replys ";
		$sql .= "ON answers.id = replys.answer_id ";
		$sql .= "LEFT OUTER JOIN users ";
		$sql .= "ON replys.user_table_id = users.id ";
		$sql .= "WHERE ";
		$sql .= "replys.answer_id IS NOT NULL ";
		$sql .= "AND ";
		$sql .= "users.id IS NOT NULL ";
		$sql .= "AND ";
		$sql .= "answers.delete_flg = 0 ";
		$sql .= "AND ";
		$sql .= "replys.delete_flg = 0 ";
		$sql .= "AND ";
		$sql .= "answer_id = :answer_id ";

		// 並べ替え条件の追加
		if ($order_by !== "") {
			$sql .= "ORDER BY ";
			$sql .= "replys.updated_at ";
			$sql .= $order_by;
		}

		// パラメータ設定
		$param = [];
		$param["answer_id"] = $answer_id;

		try {
			// SQLを実行
			$result = DB::select($sql, $param);
			// オブジェクトを配列に変換して格納
			$reply_data = json_decode(json_encode($result), true);
			// 取得した件数をカウント
			$select_count = count($reply_data);
			// 取得したデータの件数を返す
			return $select_count;

		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}



	/**
	 * 指定のタグの質問IDとタイトル、件数を取得する
	 * 
	 * @param array $question_data 取得したデータを格納する配列
	 * @param string $question_id 指定の質問ID
	 * @param string $tag_id 指定のタグID
	 * @param string $order_by DESC or ASC
	 * @return int $select_count 取得したデータの件数1を返す エラー時は-1を返す
	 */
	public function selectQuestionsTitle(&$question_data, $question_id, $tag_id, $order_by)
	{
		// 質問IDがない場合は-1を返して処理終了
		if ($question_id == "" || $tag_id == "") {
			return -1;
		}

		// データ格納用配列の初期化
		$question = [];

		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "questions.id AS id, ";
		$sql .= "questions.question_title AS question_title, ";
		$sql .= "questions.created_at, ";
		$sql .= "questions.updated_at ";
		$sql .= "FROM questions ";
		$sql .= "LEFT OUTER JOIN tag_maps ";
		$sql .= "ON questions.id = tag_maps.question_id ";
		$sql .= "WHERE ";
		$sql .= "tag_maps.question_id IS NOT NULL ";
		$sql .= "AND ";
		$sql .= "questions.delete_flg = 0 ";
		$sql .= "AND ";
		$sql .= "questions.id = :question_id ";
		$sql .= "AND ";
		$sql .= "tag_maps.tag_table_id = :tag_id ";

		// パラメータ設定
		$param = [];
		$param["question_id"] = $question_id;
		$param["tag_id"] = $tag_id;

		// 並べ替え条件の追加
		if ($order_by !== "") {
			$sql .= "ORDER BY ";
			$sql .= "questions.updated_at ";
			$sql .= $order_by;
		}

		try {
			// SQLを実行
			$result = DB::select($sql, $param);
			// オブジェクトを配列に変換して格納
			$question_data = json_decode(json_encode($result), true);
			// 取得した件数をカウント
			$select_count = count($question_data);
			// 取得したデータの件数を返す
			return $select_count;

		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}



	/**
	 * 指定の質問に指定のユーザーがいいねをしているかチェック
	 * 
	 * @param string $question_id 質問ID
	 * @param string $user_table_id ユーザーテーブルID
	 * @return int $select_count いいねをしている場合1、していない場合0、エラー-1
	 */
	public function checkGoodQuestions($question_id, $user_table_id)
	{
		// クエッションIDかユーザーテーブルIDがない場合は-1を返して処理終了
		if ($question_id == "" || $user_table_id == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "SELECT id AS id ";
		$sql .= "FROM good_question_maps ";
		$sql .= "WHERE ";
		$sql .= "question_id = :question_id ";
		$sql .= "AND ";
		$sql .= "user_table_id = :user_table_id ";
		$sql .= "LIMIT 1; ";

		// パラメータ設定
		$param = [];
		$param["question_id"] = $question_id;
		$param["user_table_id"] = $user_table_id;

		try {
			// SQLを実行
			$result = DB::select($sql, $param);
			// オブジェクトを配列に変換して格納
			$result_data = json_decode(json_encode($result), true);
			// 取得した件数をカウント
			$select_count = count($result_data);
			// 取得したデータの件数を返す
			return $select_count;
		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}



	/**
	 * 指定の回答に指定のユーザーがいいねをしているかチェック
	 * 
	 * @param string $answer_id 回答のID
	 * @param string $user_table_id ユーザーテーブルID
	 * @return int $select_count いいねをしている場合1、していない場合0、エラー-1
	 */
	public function checkGoodAnswers($answer_id, $user_table_id)
	{
		// 質問IDかユーザーテーブルIDがない場合は-1を返して処理終了
		if ($answer_id == "" || $user_table_id == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "SELECT id AS id ";
		$sql .= "FROM good_answer_maps ";
		$sql .= "WHERE ";
		$sql .= "answer_id = :answer_id ";
		$sql .= "AND ";
		$sql .= "user_table_id = :user_table_id ";
		$sql .= "LIMIT 1; ";

		// パラメータ設定
		$param = [];
		$param["answer_id"] = $answer_id;
		$param["user_table_id"] = $user_table_id;

		try {
			// SQLを実行
			$result = DB::select($sql, $param);
			// オブジェクトを配列に変換して格納
			$result_data = json_decode(json_encode($result), true);
			// 取得した件数をカウント
			$select_count = count($result_data);
			// 取得したデータの件数を返す
			return $select_count;
		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}
}
