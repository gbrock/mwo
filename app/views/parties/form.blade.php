<?php

$name_input = array(
	'name' => 'name',
	'label' => Lang::get('parties.name'),
	'value' => (isset($party) ? $party->name : FALSE),
	'attr' => array(
		'autofocus',
	),
);

?>
@include('forms.input', $name_input)
