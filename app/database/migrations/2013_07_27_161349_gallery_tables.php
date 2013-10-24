<?php

use Illuminate\Database\Migrations\Migration;

class GalleryTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gallery_object' , function($table)
		{
			$table->increments('id');
			$table->string('uri');
			$table->integer('gal_id');
			$table->text('description');
			$table->timestamp('updated_at');
			$table->timestamp('created_at');
		});
		Schema::create('gallery' , function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('cat_id');
			$table->timestamp('updated_at');
			$table->timestamp('created_at');
		});
		Schema::create('gallery_cat' , function($table)
		{
			$table->increments('id');
			$table->string('name');
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
		Schema::drop('gallery_object');
		Schema::drop('gallery');
		Schema::drop('gallery_cat');
	}

}