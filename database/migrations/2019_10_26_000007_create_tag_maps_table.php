<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagMapsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tag_maps', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('question_id');
			$table->string('tag_table_id', 50);
			$table->dateTime('created_at');
			$table->dateTime('updated_at');
			$table->unique(['question_id', 'tag_table_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('tag_maps');
	}
}
