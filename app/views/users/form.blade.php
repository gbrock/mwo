@include('forms.input', array(
	'name' => 'password',
	'label' => Lang::get('auth.set_password'),
))

@include('forms.select', array(
	'name' => 'groups[]',
	'label' => Lang::get('usergroups.select_group'),
	'options' => $group_options,
	'attr' => array(
		'multiple',
	),
	'value' => $set_group_ids,
))

