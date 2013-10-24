<?php

use Illuminate\Database\Migrations\Migration;

class Messages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('messages' , function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('id');
			$table->text('message');
			$table->boolean('is_read');
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
		Schemma::drop('messages');
	}

}