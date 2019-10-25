<?php

use Illuminate\Database\Seeder;

class TagMapsSeeder extends Seeder
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
			'tag_table_id' => 4,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tag_maps')->insert($param);

		$param = [
			'question_id' => 1,
			'tag_table_id' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tag_maps')->insert($param);

		$param = [
			'question_id' => 1,
			'tag_table_id' => 5,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tag_maps')->insert($param);

		$param = [
			'question_id' => 2,
			'tag_table_id' => 2,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tag_maps')->insert($param);

		$param = [
			'question_id' => 2,
			'tag_table_id' => 3,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tag_maps')->insert($param);

		$param = [
			'question_id' => 2,
			'tag_table_id' => 4,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tag_maps')->insert($param);

		$param = [
			'question_id' => 3,
			'tag_table_id' => 5,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tag_maps')->insert($param);

		$param = [
			'question_id' => 3,
			'tag_table_id' => 3,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tag_maps')->insert($param);

		$param = [
			'question_id' => 3,
			'tag_table_id' => 4,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tag_maps')->insert($param);

		$param = [
			'question_id' => 4,
			'tag_table_id' => 7,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tag_maps')->insert($param);

		$param = [
			'question_id' => 4,
			'tag_table_id' => 8,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tag_maps')->insert($param);

		$param = [
			'question_id' => 4,
			'tag_table_id' => 9,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tag_maps')->insert($param);
	}
}
