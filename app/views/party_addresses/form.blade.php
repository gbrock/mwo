@include('forms.textarea', array(
	'name' => 'provided_as',
	'attr' => array(
		'rows' => 2,
		'placeholder' => 'Street, Apt / Suite / Floor' . "\n" . 'City, Province, Postal Code',
		'autofocus',
	),
	'label' => FALSE,
	'value' => $address->exists() ? $address->provided_as : FALSE,
))

@include('forms.input', array(
	'name' => 'type',
	'label' => 'Type',
	'attr' => array(
		'placeholder' => 'not set'
	),
	'value' => $address->exists() ? $address->type : FALSE,
))