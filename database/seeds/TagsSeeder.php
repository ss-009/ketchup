<?php

use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$param = [
			'tag_id' => 'lyrics',
			'tag_name' => '作詞',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tags')->insert($param);

		$param = [
			'tag_id' => 'compose',
			'tag_name' => '作曲',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tags')->insert($param);

		$param = [
			'tag_id' => 'arrangement',
			'tag_name' => '編曲・アレンジ',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tags')->insert($param);

		$param = [
			'tag_id' => 'instrument',
			'tag_name' => '楽器・演奏',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tags')->insert($param);

		$param = [
			'tag_id' => 'recording',
			'tag_name' => 'レコーディング',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tags')->insert($param);

		$param = [
			'tag_id' => 'mixdown',
			'tag_name' => 'ミックスダウン',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tags')->insert($param);

		$param = [
			'tag_id' => 'mastering',
			'tag_name' => 'マスタリング',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tags')->insert($param);

		$param = [
			'tag_id' => 'daw-dtm',
			'tag_name' => 'DAW・DTM全般',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tags')->insert($param);

		$param = [
			'tag_id' => 'other',
			'tag_name' => 'その他',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('tags')->insert($param);
	}
}
