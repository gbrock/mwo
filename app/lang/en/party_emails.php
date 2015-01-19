<?php

return array(
	'id' => 'E-mail ID',
	'address' => 'E-mail Address',
	'create' => Lang::get('labels.create_item', array(
    	'item' => Lang::choice('labels.party_email', 1),
    )),
	'edit' => Lang::get('labels.edit_item', array(
    	'item' => ':item',
    )),
    'empty_table' => 'There\'s nothing here yet!',
    'create_friendly' => 'Add an e-mail now',
);
