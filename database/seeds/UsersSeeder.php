<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$param = [
			'user_id' => 'taro',
			'email' => 'taro@test.com',
			'password' => 'test',
			'image' => 'https://placehold.jp/150x150.png',
			'profile' => 'よろしく',
			'score' => 0,
			'ip_address' => 'localhost.com',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('users')->insert($param);

		$param = [
			'user_id' => 'hanako',
			'email' => 'hanako@test.com',
			'password' => 'test',
			'image' => 'https://placehold.jp/300x300.png',
			'profile' => 'よろしくよろしく',
			'score' => 0,
			'ip_address' => 'localhost.com',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('users')->insert($param);

		$param = [
			'user_id' => 'junichi',
			'email' => 'junichi@test.com',
			'password' => 'test',
			'image' => 'https://placehold.jp/150x150.png',
			'profile' => 'よろしくよろしくよろしくよろしくよろしくよろしく',
			'score' => 0,
			'ip_address' => 'localhost.com',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];
		DB::table('users')->insert($param);
	}
}
