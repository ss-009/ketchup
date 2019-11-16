<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePvQuestionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pv_questions', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('question_id')->unique();
			$table->bigInteger('count_pv');
			$table->string('end_ip_address', 256)->nullable();
			$table->dateTime('created_at');
			$table->dateTime('updated_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('pv_questions');
	}
}
