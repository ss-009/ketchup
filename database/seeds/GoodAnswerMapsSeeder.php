<?php

use Illuminate\Database\Seeder;

class GoodAnswerMapsSeeder extends Seeder
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
			'answer_id' => 1,
			'user_table_id' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('good_answer_maps')->insert($param);

		$param = [
			'question_id' => 1,
			'answer_id' => 2,
			'user_table_id' => 2,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('good_answer_maps')->insert($param);
	}
}
