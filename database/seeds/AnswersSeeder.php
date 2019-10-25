<?php

use Illuminate\Database\Seeder;

class AnswersSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$param = [
			'question_id' => 1,
			'answer_content' => 'それはこうするべきです。\n自分で解決することも大切です。',
			'user_table_id' => 1,
			'best_answer_flg' => 0,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'delete_flg' => 0,
		];
		DB::table('answers')->insert($param);

		$param = [
			'question_id' => 1,
			'answer_content' => 'これはああするべきです。\nわからないことは調べることもしましょう',
			'user_table_id' => 2,
			'best_answer_flg' => 0,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'delete_flg' => 0,
		];
		DB::table('answers')->insert($param);

		$param = [
			'question_id' => 2,
			'answer_content' => 'それはこうするべきです。\n自分で思い悩んでみましょう。',
			'user_table_id' => 3,
			'best_answer_flg' => 0,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'delete_flg' => 0,
		];
		DB::table('answers')->insert($param);
	}
}
