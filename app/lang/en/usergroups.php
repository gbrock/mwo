<?php 

return array(
	'name' => 'Name',
	'create' => Lang::get('labels.create_item', array(
    	'item' => Lang::choice('labels.usergroup', 1),
    )),
    'select_group' => 'Group(s)',
	'description_friendly' => 'A set of permissions with which each user typically associates.',
	'not_found' => 'Group not found.',
	'already_exists' => 'That group already exists.',
    'create_friendly' => 'Add a group now',
    'empty_table' => 'There\'s nothing here yet!',
);
