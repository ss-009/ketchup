<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserSelectModel extends Model
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
	 * ユーザーの存在チェック
	 * 
	 * @param string $user_id 指定のユーザーID（指定時抽出文を追加）
	 * @return int $select_count 取得したデータの件数を返す エラー時は-1を返す
	 */
	public function checkUsers($user_id)
	{
		// データ格納用配列の初期化
		$user = [];

		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "user_id ";
		$sql .= "FROM users ";
		$sql .= "WHERE ";
		$sql .= "deleted_at IS NULL ";
		$sql .= "AND ";
		$sql .= "user_id = :user_id ";
		$sql .= "LIMIT 1 ";

		// パラメータ設定
		$param = [];
		$param["user_id"] = $user_id;

		try {
			// SQLを実行
			$result = DB::select($sql, $param);
			// オブジェクトを配列に変換して格納
			$user = json_decode(json_encode($result), true);
			// 取得した件数をカウント
			$select_count = count($user);
			// 取得したデータの件数を返す
			return $select_count;

		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}



	/**
	 * ユーザー情報を取得
	 * 
	 * @param Array $user_data 取得したデータを格納する配列
	 * @param String $user_id 指定のユーザーID（指定時抽出文を追加）
	 * @return Int $select_count 取得したデータの件数を返す エラー時は-1を返す
	 */
	public function selectUsers(&$user_data, $user_id)
	{
		// データ格納用配列の初期化
		$user_data = [];

		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "user_id, ";
		$sql .= "email, ";
		$sql .= "profile, ";
		$sql .= "image, ";
		$sql .= "score, ";
		$sql .= "created_at ";
		$sql .= "FROM users ";
		$sql .= "WHERE ";
		$sql .= "deleted_at IS NULL ";
		$sql .= "AND ";
		$sql .= "user_id = :user_id ";
		$sql .= "LIMIT 1 ";

		// パラメータ設定
		$param = [];
		$param["user_id"] = $user_id;

		try {
			// SQLを実行
			$result = DB::select($sql, $param);
			// オブジェクトを配列に変換して格納
			$user_data = json_decode(json_encode($result), true);
			// 取得した件数をカウント
			$select_count = count($user_data);
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
	 * @param string $user_id 指定のユーザーID（指定時抽出文を追加）
	 * @return int $select_count 取得したデータの件数を返す エラー時は-1を返す
	 */
	public function selectQuestions(&$question_list, $user_id)
	{
		// データ格納用配列の初期化
		$question_list = [];
		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "questions.id AS question_id, ";
		$sql .= "questions.question_title AS question_title, ";
		$sql .= "questions.close_flg AS close_flg, ";
		$sql .= "questions.created_at AS created_at, ";
		$sql .= "questions.updated_at AS updated_at, ";
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
		$sql .= "users.image AS image, ";
		$sql .= "pv_questions.count_pv AS count_pv ";
		$sql .= "FROM questions ";
		$sql .= "LEFT OUTER JOIN tags AS tag1 ";
		$sql .= "ON questions.tag_id_1 = tag1.id ";
		$sql .= "LEFT OUTER JOIN tags AS tag2 ";
		$sql .= "ON questions.tag_id_2 = tag2.id ";
		$sql .= "LEFT OUTER JOIN tags AS tag3 ";
		$sql .= "ON questions.tag_id_3 = tag3.id ";
		$sql .= "LEFT OUTER JOIN users ";
		$sql .= "ON questions.user_table_id = users.id ";
		$sql .= "LEFT OUTER JOIN pv_questions ";
		$sql .= "ON questions.id = pv_questions.question_id ";
		$sql .= "WHERE ";
		$sql .= "users.id IS NOT NULL ";
		$sql .= "AND ";
		$sql .= "users.deleted_at IS NULL ";
		$sql .= "AND ";
		$sql .= "questions.delete_flg = 0 ";

		// パラメータ設定
		$param = [];

		// タグ指定時はタグを抽出条件にする
		if ($user_id !== "") {
			$sql .= "AND ";
			$sql .= "users.user_id = :user_id ";
			// bind値の設定
			$param["user_id"] = $user_id;
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
	 * ユーザーが回答した質問のデータリストと質問の件数を取得する
	 * 
	 * @param array $question_list 取得したデータを格納する配列
	 * @param string $user_id 指定のユーザーID（指定時抽出文を追加）
	 * @return int $select_count 取得したデータの件数を返す エラー時は-1を返す
	 */
	public function selectAnswersQuestions(&$question_list, $user_id, $flg)
	{
		// データ格納用配列の初期化
		$question_list = [];
		// SQL文の作成
		$sql = "";
		$sql .= "SELECT ";
		$sql .= "questions.id AS question_id, ";
		$sql .= "questions.question_title AS question_title, ";
		$sql .= "questions.close_flg AS close_flg, ";
		$sql .= "questions.created_at AS created_at, ";
		$sql .= "questions.updated_at AS updated_at, ";
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
		$sql .= "users.image AS image, ";
		$sql .= "pv_questions.count_pv AS count_pv ";
		$sql .= "FROM answers ";
		$sql .= "LEFT OUTER JOIN questions ";
		$sql .= "ON answers.question_id = questions.id ";
		$sql .= "LEFT OUTER JOIN tags AS tag1 ";
		$sql .= "ON questions.tag_id_1 = tag1.id ";
		$sql .= "LEFT OUTER JOIN tags AS tag2 ";
		$sql .= "ON questions.tag_id_2 = tag2.id ";
		$sql .= "LEFT OUTER JOIN tags AS tag3 ";
		$sql .= "ON questions.tag_id_3 = tag3.id ";
		$sql .= "LEFT OUTER JOIN users ";
		$sql .= "ON answers.user_table_id = users.id ";
		$sql .= "LEFT OUTER JOIN pv_questions ";
		$sql .= "ON questions.id = pv_questions.question_id ";
		$sql .= "WHERE ";
		$sql .= "users.id IS NOT NULL ";
		$sql .= "AND ";
		$sql .= "users.deleted_at IS NULL ";
		$sql .= "AND ";
		$sql .= "questions.delete_flg = 0 ";
		$sql .= "AND ";
		$sql .= "users.user_id = :user_id ";

		if ($flg === 'b') {
			$sql .= "AND ";
			$sql .= "answers.best_answer_flg = 1 ";
		}

		// パラメータ設定
		$param = [];
		$param["user_id"] = $user_id;

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
}
