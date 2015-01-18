<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonTable extends Migration {

	protected $table = 'person';

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
			$table->integer('party_id')->unsigned();
			$table->primary('party_id');
			
			// The data
			$table->string('gender')->nullable();
			$table->date('birth')->nullable();
			
			// The trackers

			// The foreign relations
			$table->foreign('party_id')->references('id')->on('party');
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
