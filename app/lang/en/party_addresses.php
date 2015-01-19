<?php

return array(
	'id' => 'Address ID',
    'provided_as' => 'What was typed',
    'type' => 'Type',
	'create' => Lang::get('labels.create_item', array(
    	'item' => Lang::choice('labels.party_address', 1),
    )),
	'edit' => Lang::get('labels.edit_item', array(
    	'item' => ':item',
    )),
    'empty_table' => 'There\'s nothing here yet!',
    'create_friendly' => 'Add an address now',
);
