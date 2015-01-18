<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartyLinkTable extends Migration {

	protected $table = 'party_link';

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
			$table->text('url');
			
			// The trackers
			$table->timestamps();

			// The foreign relations
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
