<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartyLocationTable extends Migration {

	protected $table = 'party_location';

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
			$table->text('provided_as');
			$table->string('type', 24)->nullable();
			$table->string('delivery_line_1', 50)->nullable();
			$table->string('delivery_line_2', 50)->nullable();
			$table->string('last_line', 50)->nullable();
			
			// The trackers
			$table->timestamps();

			// The foreign relations
			$table->integer('api_id')->unsigned();
			$table->index('api_id');
			$table->foreign('api_id')->references('id')->on('api_location_result');

			$table->integer('party_id')->unsigned();
			$table->index('party_id');
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
