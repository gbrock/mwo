<?php 

return array(
	'name' => 'Name',
	'create' => Lang::get('labels.create_item', array(
    	'item' => Lang::choice('labels.usergroup', 1),
    )),
	'description_friendly' => 'A set of permissions with which each user typically associates.',
    'create_friendly' => 'Add a group now',
    'empty_table' => 'There\'s nothing here yet!',
);
