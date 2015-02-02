@if($fillable->type == 'string')
	@include('forms.input', array(
		'label' => humanize($fillable->name),
		'name' => (isset($name) && $name ? $name . '[' . $fillable->name . ']' : $fillable->name),
	))
@elseif($fillable->type == 'text')
	@include('forms.textarea', array(
		'label' => humanize($fillable->name),
		'name' => (isset($name) && $name ? $name . '[' . $fillable->name . ']' : $fillable->name),
	))
@elseif($fillable->type == 'image')
	@include('forms.upload', array(
		'label' => humanize($fillable->name),
		'name' => (isset($name) && $name ? $name . '[' . $fillable->name . ']' : $fillable->name),
		'help_text' => Lang::get('messages.minimum_image_size', array('resolution' => $fillable->size)),
	))
@elseif($fillable->type == 'collection')
	<h3>
		{{ humanize($fillable->name) }}
		{{ BS3::button(
			FALSE,
			Lang::get('labels.create'),
			'sm link',
			array(
				'name' => 'add_to_template[' . $fillable->name . ']',
				'value' => 1,
			)
		) }}
	</h3>

	@for ($i=0; $i < $items; $i++)
		@if($i !== 0)
			<hr>
		@endif

		<h4>
			#{{ $i+1 }}
			@if($items > 1)
				{{ BS3::button(
					FALSE,
					Lang::get('labels.destroy'),
					'sm link',
					array(
						'name' => 'remove_from_template[' . $fillable->name . '][' . $i . ']',
						'value' => 1,
					)
				) }}
			@endif
		</h4>
		@foreach($fillable->fillable as $f)
			@include('pages.template_fillable_form', array(
				'fillable' => $f,
				'name' => (isset($name) && $name ? $name . '[' . $fillable->name . ']' : $fillable->name) . '[' . $i . ']',
			))
		@endforeach
	@endfor
@endif