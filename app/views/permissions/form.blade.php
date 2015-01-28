@include('forms.input', array(
	'name' => 'name',
	'attr' => array(
		'autofocus',
	),
	'label' => Lang::get('security.permission_name'),
))

{{-- 

@include('forms.radio', array(
	'name' => 'allow',
	'options' => array(
		1 => 'Allowed',
		0 => 'Not Allowed',
	),
	'value' => 1,
))
--}}
