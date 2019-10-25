<?php

use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$param = [
			'question_title' => 'これってどうすればいいですか？',
			'question_content' => '作曲で悩んでいますがこれってどうすればいいでしょうか。\nギターの音が汚いです。',
			'user_table_id' => 1,
			'tag_id_1' => 4,
			'tag_id_2' => 1,
			'tag_id_3' => 5,
			'close_flg' => 0,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'delete_flg' => 0,
		];
		DB::table('questions')->insert($param);

		$param = [
			'question_title' => 'あれれれれれってどうすればいいですか？',
			'question_content' => '作曲で悩んでいますがこれってどうすればいいでしょうか。\nギターの音が汚いです。\nギターの音が汚いです。\nギターの音が汚いです。',
			'user_table_id' => 2,
			'tag_id_1' => 2,
			'tag_id_2' => 3,
			'tag_id_3' => 4,
			'close_flg' => 0,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'delete_flg' => 0,
		];
		DB::table('questions')->insert($param);

		$param = [
			'question_title' => 'れれってどうすれば？これってどうすればいいですか？',
			'question_content' => '作曲で悩んでいますがこれってどうすればいいでしょうか。\n全部音が汚いです。',
			'user_table_id' => 1,
			'tag_id_1' => 5,
			'tag_id_2' => 3,
			'tag_id_3' => 4,
			'close_flg' => 0,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'delete_flg' => 0,
		];
		DB::table('questions')->insert($param);

		$param = [
			'question_title' => 'ミックスダウンから納品まで',
			'question_content' => '納品で悩んでいますがこれってどうすればいいでしょうか。\n全部音が汚いです。',
			'user_table_id' => 3,
			'tag_id_1' => 7,
			'tag_id_2' => 8,
			'tag_id_3' => 9,
			'close_flg' => 0,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'delete_flg' => 0,
		];
		DB::table('questions')->insert($param);
	}
}
