<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartyPhoneTable extends Migration {

	protected $table = 'party_phones';

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
			$table->string('number', 64);
			$table->string('extension', 16)->nullable();
			$table->string('type', 24)->nullable();
			
			// The trackers
			$table->timestamps();

			// The foreign relations
			$table->integer('party_id')->unsigned();
			$table->index('party_id');
			$table->foreign('party_id')->references('id')->on('parties');
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
