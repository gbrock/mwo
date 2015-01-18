<?php

$gender_input = array(
	'name' => 'gender',
	'label' => Lang::get('people.gender'),
	'help_text' => Lang::get('people.gender_help'),
	'value' => (isset($party) && $party->person() ? $party->person->gender : FALSE),
);

$birth_input = array(
	'name' => 'birth',
	'label' => Lang::get('people.birth'),
	'help_text' => Lang::get('labels.optional'),
	'attr' => array(
		' type' => 'date', // the space before the key is there to trick Laravel... nasty.
	),
	'value' => (isset($party) && $party->person && $party->person->birth ? $party->person->birth->toDateString() : ''),
);

?>
<div class="row">
	<div class="col-sm-8">
		@include('forms.input', $gender_input)
	</div>
	<div class="col-xs-7 col-sm-4">
		@include('forms.input', $birth_input)
	</div>
</div>
