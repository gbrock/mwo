@include('forms.input', array(
	'name' => 'address',
	'prefix' => HTML::icon('envelope'),
	'attr' => array(
		'placeholder' => 'user@example.com',
		'autofocus',
	),
	'label' => FALSE,
	'value' => $email->exists() ? $email->address : FALSE,
))
