<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	protected $table = 'user';

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
			$table->string('username', 64)->nullable();
			$table->char('password', 60)->nullable();
			$table->timestamp('password_last_changed')->nullable();
			$table->timestamp('last_login')->nullable();
			
			// The trackers
			$table->timestamps();
			$table->softDeletes();

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
		//
	}

}
