<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySentryTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
		    /**
		     * Set up the foreign dependence on `party`
		     */
		    $table->dropColumn('id');
		    $table->integer('party_id')->unsigned()->unique();
		    $table->foreign('party_id')->references('id')->on('parties');

		    /**
		     * New columns
		     */
		    $table->string('username', 64);
		    $table->softDeletes();

		    /**
		     * These fields will be fulfilled by other tables.
		     */
		    $table->dropUnique('users_email_unique');
		    
		    $table->dropColumn('first_name');
		    $table->dropColumn('last_name');
		    $table->dropColumn('email');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
	}

}