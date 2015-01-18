<?php

$birth_input = array(
	'name' => 'founded',
	'label' => Lang::get('organizations.founded'),
	'attr' => array(
		' type' => 'date', // the space before the key is there to trick Laravel... nasty.
	),
	'value' => (isset($party) && $party->organization && $party->organization->founded ? $party->organization->founded->toDateString() : ''),
	'help_text' => Lang::get('labels.optional'),
);

?>
@include('forms.input', $birth_input)
