@include('forms.input', array(
	'name' => 'name',
	'attr' => array(
		'autofocus',
	),
	'label' => Lang::get('usergroups.name'),
	'value' => isset($group) && $group->exists() ? $group->name : FALSE,
))

