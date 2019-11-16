<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionDatailUpdateModel extends Model
{
	/**
	 * 質問の更新を行う
	 * 
	 * @param string $question_id 質問ID
	 * @param string $question_addition 質問補足
	 * @param int $user_table_id ユーザーテーブルID
	 * @param int $tag_id_1 タグID1
	 * @param int $tag_id_2 タグID2
	 * @param int $tag_id_3 タグID3
	 * @param string $last_comment 終了コメント
	 * @param date $date_time 現在日時
	 * @return boolean $result 更新した件数を返す 1：正常、0：更新対象なし、エラー時：-1を返す
	 */
	public function updateQuestions($question_id, $question_addition, $user_table_id,
									$tag_id_1, $tag_id_2, $tag_id_3, $last_comment, $date_time)
	{
		// キー項目がない場合はエラーで-1を返す
		if ($question_id == "" || $question_addition == "" || $user_table_id == "" || $tag_id_1 == "" || $date_time == "") {
			return -1;
		}

		// タグID2、タグID3が空の場合はNULLにする
		if ($tag_id_2 == "") {
			$tag_id_2 = null;
		}
		if ($tag_id_3 == "") {
			$tag_id_3 = null;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "UPDATE questions ";
		$sql .= "SET ";
		$sql .= "question_addition = :question_addition, ";
		$sql .= "tag_id_1 = :tag_id_1, ";
		$sql .= "tag_id_2 = :tag_id_2, ";
		$sql .= "tag_id_3 = :tag_id_3, ";

		// パラメータ設定
		$param = [];
		$param["question_addition"] = $question_addition;
		$param["tag_id_1"] = $tag_id_1;
		$param["tag_id_2"] = $tag_id_2;
		$param["tag_id_3"] = $tag_id_3;

		// 終了コメント入力時は終了コメントと終了フラグの更新文を追加
		if ($last_comment !== "") {
			$sql .= "last_comment = :last_comment, ";
			$sql .= "close_flg = 1, ";
			$param["last_comment"] = $last_comment;
		}

		$sql .= "updated_at = :updated_at ";
		$sql .= "WHERE ";
		$sql .= "id = :question_id ";
		$sql .= "AND ";
		$sql .= "user_table_id = :user_table_id ";

		$param["updated_at"] = $date_time;
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
	 * 質問の終了処理を行う
	 * 
	 * @param string $question_id 質問ID
	 * @param int $user_table_id ユーザーテーブルID
	 * @param string $last_comment 終了コメント
	 * @param date $date_time 現在日時
	 * @return boolean $result 更新した件数を返す 1：正常、0：更新対象なし、エラー時：-1を返す
	 */
	public function updateCloseFlgQuestions($question_id, $user_table_id, $last_comment, $date_time)
	{
		// キー項目がない場合はエラーで-1を返す
		if ($question_id == "" || $user_table_id == "" || $last_comment == "" || $date_time == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "UPDATE questions ";
		$sql .= "SET ";
		$sql .= "last_comment = :last_comment, ";
		$sql .= "close_flg = 1, ";
		$sql .= "updated_at = :updated_at ";
		$sql .= "WHERE ";
		$sql .= "id = :question_id ";
		$sql .= "AND ";
		$sql .= "user_table_id = :user_table_id ";

		// パラメータ設定
		$param = [];
		$param["question_id"] = $question_id;
		$param["user_table_id"] = $user_table_id;
		$param["last_comment"] = $last_comment;
		$param["updated_at"] = $date_time;

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
	 * 回答のベストアンサー処理を行う
	 * 
	 * @param string $answer_id 回答ID
	 * @param date $date_time 現在日時
	 * @return boolean $result 更新した件数を返す 1：正常、0：更新対象なし、エラー時：-1を返す
	 */
	public function updateBestAnswers($answer_id, $date_time)
	{
		// キー項目がない場合はエラーで-1を返す
		if ($answer_id == "" || $date_time == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "UPDATE answers ";
		$sql .= "SET ";
		$sql .= "best_answer_flg = 1, ";
		$sql .= "updated_at = :date_time ";
		$sql .= "WHERE ";
		$sql .= "id = :answer_id ";

		// パラメータ設定
		$param = [];
		$param["answer_id"] = $answer_id;
		$param["date_time"] = $date_time;

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
	 * PV数を更新する
	 * 
	 * @param string $question_id 質問ID
	 * @param int $ip_address アクセスしたIPアドレス
	 * @param date $date_time 現在日時
	 * @return boolean $result 更新した件数を返す 1：正常、0：更新対象なし、エラー時：-1を返す
	 */
	public function updatePvQuestionMaps($question_id, $ip_address, $date_time)
	{
		// キー項目がない場合はエラーで-1を返す
		if ($question_id == "" || $ip_address == "" || $date_time == "") {
			return -1;
		}

		// SQL文の作成
		$sql = "";
		$sql .= "UPDATE pv_questions ";
		$sql .= "SET ";
		$sql .= "count_pv = count_pv + 1, ";
		$sql .= "end_ip_address = :ip_address, ";
		$sql .= "updated_at = :date_time ";
		$sql .= "WHERE ";
		$sql .= "id = :question_id ";

		// パラメータ設定
		$param = [];
		$param["question_id"] = $question_id;
		$param["ip_address"] = $ip_address;
		$param["date_time"] = $date_time;

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
}