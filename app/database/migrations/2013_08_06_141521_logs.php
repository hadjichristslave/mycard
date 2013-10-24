<?php

use Illuminate\Database\Migrations\Migration;

class Logs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('log_login' , function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->text('action');
			$table->text('ip');
			$table->timestamp('updated_at');
			$table->timestamp('created_at');
		});
		Schema::create('log_traffic' , function($table)
		{
			$table->increments('id');
			$table->text('ip');
			$table->timestamp('updated_at');
			$table->timestamp('created_at');
		});
		Schema::create('blacklist_user' , function($table)
		{
			$table->increments('id');
			$table->string('username');
			$table->integer('counter');
			$table->timestamp('updated_at');
			$table->timestamp('created_at');
		});
		Schema::create('blacklist_ip' , function($table)
		{
			$table->increments('id');
			$table->string('username');
			$table->integer('counter');
			$table->timestamp('updated_at');
			$table->timestamp('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('log_login');
		Schema::drop('log_traffic');
		Schema::drop('blacklist_user');
		Schema::drop('blacklist_ip');
	}

}