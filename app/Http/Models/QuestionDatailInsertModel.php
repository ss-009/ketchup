<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionDatailInsertModel extends Model
{
	/**
	 * 回答を登録する
	 * 
	 * @param string $question_id 質問ID
	 * @param string $answer_content 回答の内容
	 * @param int $user_table_id ユーザーテーブルID
	 * @param date $date_time 現在日時
	 * @return boolean $result TRUE or FALSE 他エラー時は-1を返す
	 */
	public function insertAnswers($question_id, $answer_content, $user_table_id, $date_time)
	{
		// キー項目がない場合はエラーで-1を返す
		if ($question_id == "" || $answer_content == "" || $user_table_id == "" || $date_time == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "INSERT INTO answers ";
		$sql .= "SET ";
		$sql .= "question_id = :question_id, ";
		$sql .= "answer_content = :answer_content, ";
		$sql .= "user_table_id = :user_table_id, ";
		$sql .= "best_answer_flg = 0, ";
		$sql .= "created_at = :created_at, ";
		$sql .= "updated_at = :updated_at, ";
		$sql .= "delete_flg = 0 ";

		// パラメータ設定
		$param = [];
		$param["question_id"] = $question_id;
		$param["answer_content"] = $answer_content;
		$param["user_table_id"] = $user_table_id;
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



	/**
	 * レスを登録する
	 * 
	 * @param string $answer_id 回答ID
	 * @param string $reply_content 返答内容
	 * @param int $user_table_id ユーザーテーブルID
	 * @param date $date_time 現在日時
	 * @return boolean $result TRUE or FALSE 他エラー時は-1を返す
	 */
	public function insertReplys($answer_id, $reply_content, $user_table_id, $date_time)
	{
		// キー項目がない場合はエラーで-1を返す
		if ($answer_id == "" || $reply_content == "" || $user_table_id == "" || $date_time == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "INSERT INTO replys ";
		$sql .= "SET ";
		$sql .= "answer_id = :answer_id, ";
		$sql .= "reply_content = :reply_content, ";
		$sql .= "user_table_id = :user_table_id, ";
		$sql .= "created_at = :created_at, ";
		$sql .= "updated_at = :updated_at, ";
		$sql .= "delete_flg = 0 ";

		// パラメータ設定
		$param = [];
		$param["answer_id"] = $answer_id;
		$param["reply_content"] = $reply_content;
		$param["user_table_id"] = $user_table_id;
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



	/**
	 * 質問に対していいねを登録する
	 * 
	 * @param string $question_id 質問ID
	 * @param int $user_table_id ユーザーテーブルID
	 * @param date $date_time 現在日時
	 * @return boolean $result TRUE or FALSE 他エラー時は-1を返す
	 */
	public function insertGoodQuestionMaps($question_id, $user_table_id, $date_time)
	{
		// キー項目がない場合はエラーで-1を返す
		if ($question_id == "" || $user_table_id == "" || $date_time == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "INSERT INTO good_question_maps ";
		$sql .= "SET ";
		$sql .= "question_id = :question_id, ";
		$sql .= "user_table_id = :user_table_id, ";
		$sql .= "created_at = :created_at, ";
		$sql .= "updated_at = :updated_at ";

		// パラメータ設定
		$param = [];
		$param["question_id"] = $question_id;
		$param["user_table_id"] = $user_table_id;
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



	/**
	 * 回答に対していいねを登録する
	 * 
	 * @param string $answer_id 回答ID
	 * @param int $user_table_id ユーザーテーブルID
	 * @param date $date_time 現在日時
	 * @return boolean $result TRUE or FALSE 他エラー時は-1を返す
	 */
	public function insertGoodAnswerMaps($answer_id, $user_table_id, $date_time)
	{
		// キー項目がない場合はエラーで-1を返す
		if ($answer_id == "" || $user_table_id == "" || $date_time == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "INSERT INTO good_answer_maps ";
		$sql .= "SET ";
		$sql .= "answer_id = :answer_id, ";
		$sql .= "user_table_id = :user_table_id, ";
		$sql .= "created_at = :created_at, ";
		$sql .= "updated_at = :updated_at ";

		// パラメータ設定
		$param = [];
		$param["answer_id"] = $answer_id;
		$param["user_table_id"] = $user_table_id;
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