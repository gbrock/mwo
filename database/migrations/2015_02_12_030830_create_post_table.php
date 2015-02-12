<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->bigIncrements('id');

			$table->string('title');
			$table->string('name')->unique();
			$table->string('status', 24)->default('draft');
			$table->date('date')->nullable();
			$table->longText('content');
			$table->text('excerpt');

			$table->bigInteger('author')->unsigned();
			$table->foreign('author')->references('id')->on('users');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
