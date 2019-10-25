<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplysTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('replys', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('answer_id');
			$table->string('reply_content', 1000);
			$table->bigInteger('user_table_id');
			$table->dateTime('created_at');
			$table->dateTime('updated_at');
			$table->dateTime('deleted_at')->nullable();
			$table->unsignedTinyInteger('delete_flg')->length(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('replys');
	}
}
