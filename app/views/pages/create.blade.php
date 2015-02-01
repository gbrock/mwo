<p class="lead text-muted">
	<span class="fa fa-plus">&nbsp;</span>
	@lang('pages.create')
</p>

{{ Form::open(array(
	'action' => 'PageController@store',
)) }}
	<div class="form-group">
		<div class="btn-group">
			@foreach($templates as $t)
				{{ BS3::button(
					FALSE,
					$t->name,
					'default',
					array(
						'name' => 'template',
						'value' => $t->key,
						'class' => ($selected_template->key == $t->key ? 'active' : '')
					)
				) }}

			@endforeach
		</div>
	</div>
{{ Form::close() }}

{{ Form::open(array(
	'action' => 'PageController@store',
	'files' => TRUE,
)) }}

	@include('pages.form')
	@include('forms.submit')

{{ Form::close() }}
