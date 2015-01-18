<?php

return array(
	'id' => 'Party ID',
	'name' => 'Display Name',
	'create' => Lang::get('labels.create_item', array(
    	'item' => Lang::choice('labels.party', 1),
    )),
	'edit' => Lang::get('labels.edit_item', array(
    	'item' => ':item',
    )),
    'description' => 'a listing of every person and organization in the system',
    'create_friendly' => 'Add someone to your list now',
    'empty_table' => 'There\'s nothing here yet!',
);
