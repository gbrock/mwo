<?php

return array(
	'id' => 'Link ID',
	'create' => Lang::get('labels.create_item', array(
    	'item' => Lang::choice('labels.party_link', 1),
    )),
	'edit' => Lang::get('labels.edit_item', array(
    	'item' => ':item',
    )),
    'empty_table' => 'There\'s nothing here yet!',
);
