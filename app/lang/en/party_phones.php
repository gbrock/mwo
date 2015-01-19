<?php

return array(
	'id' => 'Phone ID',
    'number' => 'Phone Number',
    'extension' => 'Extension',
	'type' => 'Type',
	'create' => Lang::get('labels.create_item', array(
    	'item' => Lang::choice('labels.party_phone', 1),
    )),
	'edit' => Lang::get('labels.edit_item', array(
    	'item' => ':item',
    )),
    'empty_table' => 'There\'s nothing here yet!',
    'create_friendly' => 'Add a phone number now',

    'format_number' => ':number',
    'format_number_w_extension' => ':number x(:extension)',
);
