<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TopSelectModel extends Model
{
	public function test(&$question_list, $keyword){
		// データ格納用配列の初期化
		$question_list = [];
		$param = [];
		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "id AS id, ";
		$sql .= "question_title AS question_title ";
		$sql .= "FROM questions ";
		$sql .= "WHERE ";
		$sql .= "question_title LIKE :question_title ";

		$param["question_title"] = "%". $keyword. "%";

		try {
			// SQLを実行
			$result = DB::select($sql, $param);
			// オブジェクトを配列に変換して格納
			$question_list = json_decode(json_encode($result), true);
			// 取得した件数をカウント
			$select_count = count($question_list);
			// 取得したデータの件数を返す
			return $select_count;
		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}

	/**
	 * 質問リスト（ユーザー情報含む）と質問の件数を取得する
	 * 
	 * @param array $question_list 取得したデータを格納する配列
	 * @param string $tag_id 指定のタグID（指定時抽出文を追加）
	 * @param string $keyword 指定のキーワード（指定時抽出文を追加）
	 * @return int $select_count 取得したデータの件数を返す エラー時は-1を返す
	 */
	public function selectQuestions(&$question_list, $tag_id, $keyword)
	{
		// データ格納用配列の初期化
		$question_list = [];
		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "questions.id AS question_id, ";
		$sql .= "questions.question_title AS question_title, ";
		$sql .= "questions.close_flg AS close_flg, ";
		$sql .= "DATE_FORMAT(questions.created_at, '%Y年%c月%e日 %H:%i') AS created_at, ";
		$sql .= "tag1.id AS tag_table_id_1, ";
		$sql .= "tag2.id AS tag_table_id_2, ";
		$sql .= "tag3.id AS tag_table_id_3, ";
		$sql .= "tag1.tag_id AS tag_id_1, ";
		$sql .= "tag2.tag_id AS tag_id_2, ";
		$sql .= "tag3.tag_id AS tag_id_3, ";
		$sql .= "tag1.tag_name AS tag_name_1, ";
		$sql .= "tag2.tag_name AS tag_name_2, ";
		$sql .= "tag3.tag_name AS tag_name_3, ";
		$sql .= "users.user_id AS user_id, ";
		$sql .= "users.image AS image ";
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

		// パラメータ設定
		$param = [];

		// タグ指定時はタグを抽出条件にする
		if ($tag_id !== "") {
			$sql .= "AND ";
			$sql .= "(questions.tag_id_1 = (SELECT id FROM tags WHERE tag_id = :tag_id_1 LIMIT 1) ";
			$sql .= "OR ";
			$sql .= "questions.tag_id_2 = (SELECT id FROM tags WHERE tag_id = :tag_id_2 LIMIT 1) ";
			$sql .= "OR ";
			$sql .= "questions.tag_id_3 = (SELECT id FROM tags WHERE tag_id = :tag_id_3 LIMIT 1)) ";
			// bind値の設定
			$param["tag_id_1"] = $tag_id;
			$param["tag_id_2"] = $tag_id;
			$param["tag_id_3"] = $tag_id;

		// キーワード入力時はキーワードを抽出条件にする
		} else if ($keyword !== "") {
			// 検索キーワードが複数入力されている場合
			if (strpos($keyword,' ') !== false || strpos($keyword,'　') !== false) {
				// 全角スペース入力時、半角スペースに変換
				if (strpos($keyword,'　') !== false) {
					$keyword = str_replace("　", " ", $keyword);
				}
				// 半角スペースを配列に変換
				if (strpos($keyword,' ') !== false) {
					$array_keyword = explode(" ", $keyword);
				}
				// カウント値を設定
				$count = 0;
				// 配列の数だけ条件を付加
				foreach ($array_keyword as $keyword_x ){
					$sql .= "AND ";
					$sql .= "(questions.question_title LIKE :question_title". $count. " ";
					$sql .= "OR ";
					$sql .= "questions.question_content LIKE :question_content". $count. " ";
					$sql .= "OR ";
					$sql .= "questions.question_addition LIKE :question_addition". $count. ") ";
					// bind値の設定
					$param["question_title". $count] = "%". $keyword_x. "%";
					$param["question_content". $count] = "%". $keyword_x. "%";
					$param["question_addition". $count] = "%". $keyword_x. "%";
					// カウント値を++
					$count++;
				}
			// 検索キーワードが１つの場合
			} else {
				$sql .= "AND ";
				$sql .= "(questions.question_title LIKE :question_title ";
				$sql .= "OR ";
				$sql .= "questions.question_content LIKE :question_content ";
				$sql .= "OR ";
				$sql .= "questions.question_addition LIKE :question_addition) ";
				// bind値の設定
				$param["question_title"] = "%". $keyword. "%";
				$param["question_content"] = "%". $keyword. "%";
				$param["question_addition"] = "%". $keyword. "%";
			}
		}

		$sql .= "ORDER BY questions.id DESC ";

		try {
			// SQLを実行
			$result = DB::select($sql, $param);
			// オブジェクトを配列に変換して格納
			$question_list = json_decode(json_encode($result), true);
			// 取得した件数をカウント
			$select_count = count($question_list);
			// 取得したデータの件数を返す
			return $select_count;

		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}



	/**
	 * 質問の回答数を取得する
	 * 
	 * @param string $question_id 質問のID
	 * @return int $select_count 取得したデータの件数を返す エラー時は-1を返す
	 */
	public function selectCountAnswers($question_id)
	{
		// 質問IDがない場合は-1を返して処理終了
		if ($question_id == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "count(answers.id) AS count_answers_id ";
		$sql .= "FROM questions ";
		$sql .= "LEFT OUTER JOIN answers ";
		$sql .= "ON questions.id = answers.question_id ";
		$sql .= "WHERE ";
		$sql .= "answers.question_id IS NOT NULL ";
		$sql .= "AND ";
		$sql .= "questions.delete_flg = 0 ";
		$sql .= "AND ";
		$sql .= "answers.delete_flg = 0 ";
		$sql .= "AND ";
		$sql .= "questions.id = :questions_id ";

		// パラメータ設定
		$param = [];
		$param["questions_id"] = $question_id;

		try {
			// SQLを実行
			$result = DB::select($sql, $param);
			// オブジェクトからカウント件数を取得
			$select_count = $result[0]->count_answers_id;
			// 取得したカウント件数を返す
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
	 * タグ一覧とタグの件数を取得する
	 * 
	 * @param array $tag_list 取得したデータを格納する配列
	 * @return int $select_count 取得したデータの件数を返す エラー時は-1を返す
	 */
	public function selectTagsCount(&$count_tag_list)
	{
		// データ格納用配列の初期化
		$tag_list = [];

		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "tags.tag_id AS tag_id, ";
		$sql .= "tags.tag_name AS tag_name, ";
		$sql .= "count(tag_maps.tag_table_id) AS count_tag_id ";
		$sql .= "FROM tags ";
		$sql .= "LEFT OUTER JOIN tag_maps ";
		$sql .= "ON tags.id = tag_maps.tag_table_id ";
		$sql .= "GROUP BY tag_maps.tag_table_id ";
		$sql .= "ORDER BY count_tag_id DESC ";

		try {
			// SQLを実行
			$result = DB::select($sql);
			// オブジェクトを配列に変換して格納
			$count_tag_list = json_decode(json_encode($result), true);
			// 取得した件数をカウント
			$select_count = count($count_tag_list);
			// 取得したデータの件数を返す
			return $select_count;

		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}

	/**
	 * ユーザー情報の一覧と件数を取得する
	 * 
	 * @param array $user_list 取得したデータを格納する配列
	 * @return int $select_count 取得したデータの件数を返す エラー時は-1を返す
	 */
	public function selectUsers(&$user_list)
	{
		// データ格納用配列の初期化
		$user_list = [];

		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "user_id AS user_id, ";
		$sql .= "image AS image, ";
		$sql .= "score AS score ";
		$sql .= "FROM users ";
		$sql .= "ORDER BY score ASC ";

		try {
			// SQLを実行
			$result = DB::select($sql);
			// オブジェクトを配列に変換して格納
			$user_list = json_decode(json_encode($result), true);
			// 取得した件数をカウント
			$select_count = count($user_list);
			// 取得したデータの件数を返す
			return $select_count;

		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}
}
