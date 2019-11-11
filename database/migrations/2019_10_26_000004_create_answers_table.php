<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('answers', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('question_id');
			$table->string('answer_content', 2000);
			$table->bigInteger('user_table_id');
			$table->unsignedTinyInteger('best_answer_flg');
			$table->dateTime('created_at');
			$table->dateTime('updated_at');
			$table->datetime('deleted_at')->nullable();
			$table->unsignedTinyInteger('delete_flg');
			$table->unique(['question_id', 'id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('answers');
	}
}
