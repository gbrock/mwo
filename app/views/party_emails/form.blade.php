@include('forms.input', array(
	'name' => 'address',
	'prefix' => HTML::icon('envelope', 0),
	'attr' => array(
		'placeholder' => 'user@example.com',
		'autofocus',
	),
	'label' => isset($label) ? $label : FALSE,
	'value' => isset($email) && $email->exists() ? $email->address : FALSE,
))
