<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

	protected $table = 'pages';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->table, function($table)
		{
			// The storage engine
			$table->engine = 'InnoDB';

			// The primary key
			$table->increments('id');
			
			// The data
			$table->string('title', 255)->nullable();
			$table->string('url', 255)->unique();
			$table->string('template', 64);
			$table->timestamp('publish_at')->nullable();
			
			// The trackers
			$table->timestamps();
			$table->softDeletes();

			// The foreign relations
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->table);
	}

}
