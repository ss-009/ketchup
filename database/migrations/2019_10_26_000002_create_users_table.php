<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('user_id', 20)->unique();
			$table->string('provider_id')->nullable();
			$table->string('provider_name')->nullable();
			$table->string('email', 256)->unique();
			$table->string('password', 256)->nullable();
			$table->string('profile', 2000)->nullable();
			$table->string('image', 512)->nullable();
			$table->bigInteger('score');
			$table->string('ip_address', 256);
			$table->dateTime('created_at');
			$table->dateTime('updated_at');
			$table->datetime('deleted_at')->nullable();;
			$table->rememberToken();
			$table->unique(['provider_id', 'provider_name']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
