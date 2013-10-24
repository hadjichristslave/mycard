<?php

use Illuminate\Database\Migrations\Migration;

class Users extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('users' , function($table)
		{
			$table->increments('id');
			$table->string('username');
			$table->string('password');
			$table->integer('group_id');
			$table->timestamp('updated_at');
			$table->timestamp('created_at');
		});
		Schema::create('user_groups' , function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->text('r_privileges');
			$table->text('w_privileges');
			$table->text('x_privileges');
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
		Schema::drop('users');
		Schema::drop('user_groups');
	}

}