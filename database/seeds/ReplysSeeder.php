<?php

use Illuminate\Database\Seeder;

class ReplysSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$param = [
			'answer_id' => 1,
			'reply_content' => 'こうすればいいですよ\nこうすればOKです',
			'user_table_id' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'delete_flg' => 0,
		];
		DB::table('replys')->insert($param);

		$param = [
			'answer_id' => 1,
			'reply_content' => 'こうすればダメですよ\nこうすればダメです',
			'user_table_id' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'delete_flg' => 0,
		];
		DB::table('replys')->insert($param);

		$param = [
			'answer_id' => 2,
			'reply_content' => 'こうすればそうですよ\nこうすればそうです',
			'user_table_id' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'delete_flg' => 0,
		];
		DB::table('replys')->insert($param);
	}
}
