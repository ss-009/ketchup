<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodQuestionMapsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('good_question_maps', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('question_id');
			$table->bigInteger('user_table_id');
			$table->dateTime('created_at');
			$table->dateTime('updated_at');
			$table->unique(['question_id', 'user_table_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('good_question_maps');
	}
}
