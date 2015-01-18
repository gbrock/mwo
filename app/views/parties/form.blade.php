<?php

$name_input = array(
	'name' => 'name',
	'label' => Lang::get('parties.name'),
	'value' => (isset($party) ? $party->name : FALSE),
);

?>
@include('forms.input', $name_input)
