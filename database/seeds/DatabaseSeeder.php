<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(UsersSeeder::class);
		$this->call(QuestionsSeeder::class);
		$this->call(AnswersSeeder::class);
		$this->call(ReplysSeeder::class);
		$this->call(TagsSeeder::class);
		$this->call(TagMapsSeeder::class);
		$this->call(GoodQuestionMapsSeeder::class);
		$this->call(GoodAnswerMapsSeeder::class);
		$this->call(PvQuestionsSeeder::class);
	}
}
