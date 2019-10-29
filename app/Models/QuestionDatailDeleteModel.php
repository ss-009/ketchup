<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionDatailDeleteModel extends Model
{
	/**
	 * 質問の削除を行う（削除フラグを1にする）
	 * 
	 * @param string $question_id 質問ID
	 * @param int $user_table_id ユーザーテーブルID
	 * @param date $date_time 現在日時
	 * @return boolean $result 更新した件数を返す 1：正常、0：更新対象なし、エラー時：-1を返す
	 */
	public function deleteQuestions($question_id, $user_table_id, $date_time)
	{
		// キー項目がない場合はエラーで-1を返す
		if ($question_id == "" || $user_table_id == "" || $date_time == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "UPDATE questions ";
		$sql .= "SET ";
		$sql .= "deleted_at = :deleted_at, ";
		$sql .= "delete_flg = 1 ";
		$sql .= "WHERE ";
		$sql .= "id = :question_id ";
		$sql .= "AND ";
		$sql .= "user_table_id = :user_table_id ";

		// パラメータ設定
		$param = [];
		$param["deleted_at"] = $date_time;
		$param["question_id"] = $question_id;
		$param["user_table_id"] = $user_table_id;

		try {
			// SQLを実行
			$result = DB::update($sql, $param);
			// 更新した件数を返す
			return $result;
		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}



	/**
	 * 回答の削除を行う（削除フラグを1にする）
	 * 
	 * @param string $answers_id 回答ID
	 * @param int $user_table_id ユーザーテーブルID
	 * @param date $date_time 現在日時
	 * @return boolean $result 更新した件数を返す 1：正常、0：更新対象なし、エラー時：-1を返す
	 */
	public function deleteAnswers($answers_id, $user_table_id, $date_time)
	{
		// キー項目がない場合はエラーで-1を返す
		if ($answers_id == "" || $user_table_id == "" || $date_time == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "UPDATE answers ";
		$sql .= "SET ";
		$sql .= "deleted_at = :deleted_at, ";
		$sql .= "delete_flg = 1 ";
		$sql .= "WHERE ";
		$sql .= "id = :answers_id ";
		$sql .= "AND ";
		$sql .= "user_table_id = :user_table_id ";

		// パラメータ設定
		$param = [];
		$param["deleted_at"] = $date_time;
		$param["answers_id"] = $answers_id;
		$param["user_table_id"] = $user_table_id;

		try {
			// SQLを実行
			$result = DB::update($sql, $param);
			// 更新した件数を返す
			return $result;
		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}



	/**
	 * 質問のいいねを削除する
	 * 
	 * @param string $question_id 質問ID
	 * @param int $user_table_id ユーザーテーブルID
	 * @return int 削除した件数を返す 1：正常、0：更新対象なし、エラー時：-1を返す
	 */
	public function deleteGoodQuestionMaps($question_id, $user_table_id)
	{
		// キー項目がない場合はエラーで-1を返す
		if ($question_id == "" || $user_table_id == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "DELETE FROM good_question_maps ";
		$sql .= "WHERE ";
		$sql .= "id = :question_id ";
		$sql .= "AND ";
		$sql .= "user_table_id = :user_table_id ";

		// パラメータ設定
		$param = [];
		$param["question_id"] = $question_id;
		$param["user_table_id"] = $user_table_id;

		try {
			// SQLを実行
			$result = DB::delete($sql, $param);
			// 削除の結果を返す
			return $result;
		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}



	/**
	 * 回答のいいねを削除する
	 * 
	 * @param string $answer_id 回答ID
	 * @param int $user_table_id ユーザーテーブルID
	 * @return int 削除した件数を返す 1：正常、0：更新対象なし、エラー時：-1を返す
	 */
	public function deleteGoodAnswersMaps($answer_id, $user_table_id)
	{
		// キー項目がない場合はエラーで-1を返す
		if ($answer_id == "" || $user_table_id == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "DELETE FROM good_answer_maps ";
		$sql .= "WHERE ";
		$sql .= "id = :answer_id ";
		$sql .= "AND ";
		$sql .= "user_table_id = :user_table_id ";

		// パラメータ設定
		$param = [];
		$param["answer_id"] = $answer_id;
		$param["user_table_id"] = $user_table_id;

		try {
			// SQLを実行
			$result = DB::delete($sql, $param);
			// 削除の結果を返す
			return $result;
		} catch (\Exception $e){
			// エラー時は-1を返す
			return -1;
		}
	}
}