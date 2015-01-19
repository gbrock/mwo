@include('forms.input', array(
	'name' => 'number',
	'attr' => array(
		' type' => 'tel', // the space before the key is there to trick Laravel... nasty.
		'autofocus',
	),
	'label' => FALSE,
	'value' => $phone->exists() ? $phone->number : FALSE,
))

<div class="row">
	<div class="col-lg-5">
		@include('forms.input', array(
			'name' => 'extension',
			'label' => 'Extension',
			'attr' => array(
				'placeholder' => 'not set'
			),
			'prefix' => 'x',
			'value' => $phone->exists() ? $phone->extension : FALSE,
		))
		
	</div>
	<div class="col-lg-7">
		@include('forms.input', array(
			'name' => 'type',
			'label' => 'Type',
			'attr' => array(
					'placeholder' => 'not set'
			),
			'options' => array(
				'c' => 'Cell',
				'h' => 'Home',
			),
			'value' => $phone->exists() ? $phone->type : FALSE,
		))
	</div>
</div>
