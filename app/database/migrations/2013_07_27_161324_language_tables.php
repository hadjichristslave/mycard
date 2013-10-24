<?php

use Illuminate\Database\Migrations\Migration;

class LanguageTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('language' , function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamp('updated_at');
			$table->timestamp('created_at');
		});

		//
		Schema::create('cms' , function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('category_id');
			$table->integer('order');
			$table->integer('lang_id');
			$table->text('title');
			$table->text('content');
			$table->text('tags');
			$table->timestamp('updated_at');
			$table->timestamp('created_at');
		});
		//
		Schema::create('cms_gallery' , function($table)
		{
			$table->integer('gal_id');
			$table->integer('cms_id');
			$table->timestamp('updated_at');
			$table->timestamp('created_at');
		});
		//
		Schema::create('cms_category' , function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->smallInteger('has_gallery');
			$table->text('cs_pages');
			$table->smallInteger('has_tags');
			$table->timestamp('updated_at');
			$table->timestamp('created_at');
		});
		//
		Schema::create('cms_cat_privilages' , function($table){
			$table->integer('cms_cat_id');
			$table->integer('r_privilege_lvl');
			$table->integer('w_privilege_lvl');
			$table->integer('x_privilege_lvl');
			$table->timestamp('updated_at');
			$table->timestamp('created_at');
		});
		//
		Schema::create('cms_tags'  , function($table){
			$table->increments('id');
			$table->string('name');
			$table->timestamp('updated_at');
			$table->timestamp('created_at');
		});
		Schema::create('cms_pages'  , function($table){
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
		Schema::drop('language');
		Schema::drop('cms');
		Schema::drop('cms_gallery');
		Schema::drop('cms_category');
		Schema::drop('cms_tags');
		Schema::drop('cms_pages');
		Schema::drop('cms_cat_privilages');
		//
	}


}