<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('question_title', 50);
			$table->string('question_content', 2000);
			$table->string('question_addition', 1000)->nullable();
			$table->bigInteger('user_table_id');
			$table->bigInteger('tag_id_1');
			$table->bigInteger('tag_id_2')->nullable();
			$table->bigInteger('tag_id_3')->nullable();
			$table->string('last_comment', 40)->nullable();
			$table->unsignedTinyInteger('close_flg');
			$table->dateTime('created_at');
			$table->dateTime('updated_at');
			$table->datetime('deleted_at')->nullable();
			$table->unsignedTinyInteger('delete_flg');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('questions');
	}
}
