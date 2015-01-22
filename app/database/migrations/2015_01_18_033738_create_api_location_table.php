<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiLocationTable extends Migration {

	protected $table = 'api_location_results';

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
			$table->text('request');

			$table->string('delivery_line_1', 50)->nullable();
			$table->string('delivery_line_2', 50)->nullable();
			$table->string('last_line', 50)->nullable();
			$table->string('delivery_point_barcode', 12)->nullable();

			$table->string('urbanization', 64)->nullable();
			$table->string('primary_number', 30)->nullable();
			$table->string('street_name', 64)->nullable();
			$table->char('street_predirection', 16)->nullable();
			$table->char('street_postdirection', 16)->nullable();
			$table->char('street_suffix', 16)->nullable();
			$table->string('secondary_number', 32)->nullable();
			$table->string('secondary_designator', 16)->nullable();
			$table->string('extra_secondary_number', 32)->nullable();
			$table->string('extra_secondary_designator', 16)->nullable();
			$table->string('pmb_designator', 16)->nullable();
			$table->string('pmb_number', 16)->nullable();
			$table->string('city_name', 64)->nullable();
			$table->string('default_city_name', 64)->nullable();
			$table->char('state_abbreviation', 2)->nullable();
			$table->char('zipcode', 5)->nullable();
			$table->char('plus4_code', 4)->nullable();
			$table->char('delivery_point', 2)->nullable();
			$table->char('delivery_point_check_digit', 1)->nullable();

			$table->char('record_type', 1)->nullable();
			$table->string('zip_type', 32)->nullable();
			$table->char('county_fips', 5)->nullable();
			$table->string('county_name', 64)->nullable();
			$table->char('carrier_route', 4)->nullable();
			$table->char('congressional_district', 2)->nullable();
			$table->char('building_default_indicator', 1)->nullable();
			$table->string('rdi', 12)->nullable();
			$table->string('elot_sequence', 4)->nullable();
			$table->string('elot_sort', 4)->nullable();
			$table->decimal('latitude', 9,6)->nullable();
			$table->decimal('longitude', 9,6)->nullable();
			$table->string('precision', 18)->nullable();
			$table->string('time_zone', 48)->nullable();
			$table->decimal('utc_offset', 4,2)->nullable();
			$table->char('dst', 5)->nullable();

			$table->string('dpv_match_code', 1)->nullable();
			$table->string('dpv_footnotes', 32)->nullable();
			$table->string('dpv_cmra', 1)->nullable();
			$table->string('dpv_vacant', 1)->nullable();
			$table->string('active', 1)->nullable();
			$table->char('ews_match', 5)->nullable();
			$table->string('footnotes', 12)->nullable();
			$table->string('lacslink_code', 2)->nullable();
			$table->string('lacslink_indicator', 1)->nullable();
			$table->string('suitelink_match', 5)->nullable();
			
			// The trackers
			$table->timestamps();

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
