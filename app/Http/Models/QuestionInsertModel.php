<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionInsertModel extends Model
{
	/**
	 * 質問を登録する
	 * 
	 * @param string $question_title 質問のタイトル
	 * @param string $question_content 質問の内容
	 * @param int $user_table_id ユーザーテーブルID
	 * @param int $tag_id_1 タグ1
	 * @param int $tag_id_2 タグ2
	 * @param int $tag_id_3 タグ3
	 * @param date $date_time 現在日時
	 * @return boolean $result TRUE or FALSE 他エラー時は-1を返す
	 */
	public function insertQuestions($question_title, $question_content, $user_table_id,
									$tag_id_1, $tag_id_2, $tag_id_3, $date_time)
	{
		// キー項目がない場合はエラーで-1を返す
		if ($question_title == "" || $question_content == "" || $user_table_id == "" || $tag_id_1 == "") {
			return -1;
		}
		// タグIDの２と３が未選択の場合はNULLとする
		if ($tag_id_2 == "") {
			$tag_id_2 = null;
		}
		if ($tag_id_3 == "") {
			$tag_id_3 = null;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "INSERT INTO questions ";
		$sql .= "SET ";
		$sql .= "question_title = :question_title, ";
		$sql .= "question_content = :question_content, ";
		$sql .= "user_table_id = :user_table_id, ";
		$sql .= "tag_id_1 = :tag_id_1, ";
		$sql .= "tag_id_2 = :tag_id_2, ";
		$sql .= "tag_id_3 = :tag_id_3, ";
		$sql .= "close_flg = 0, ";
		$sql .= "created_at = :created_at, ";
		$sql .= "updated_at = :updated_at, ";
		$sql .= "delete_flg = 0 ";

		// パラメータ設定
		$param = [];
		$param["question_title"] = $question_title;
		$param["question_content"] = $question_content;
		$param["user_table_id"] = $user_table_id;
		$param["tag_id_1"] = $tag_id_1;
		$param["tag_id_2"] = $tag_id_2;
		$param["tag_id_3"] = $tag_id_3;
		$param["created_at"] = $date_time;
		$param["updated_at"] = $date_time;

		try {
			// SQLを実行
			$result = DB::insert($sql, $param);
			// インサートの結果を返す
			return $result;

		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}
}