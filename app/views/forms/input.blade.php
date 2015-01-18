@extends('forms.group')

@section('control')
	@if(isset($prefix) || isset($suffix) || isset($prefix_btn) || isset($suffix_btn))
		<div class="input-group{{ isset($input_group_class) ? ' ' . $input_group_class : FALSE }}">
	@endif

	@if(isset($prefix) && $prefix)
		<div class="input-group-addon">
			{{ $prefix }}
		</div>
	@endif

	@if(isset($prefix_btn) && $prefix_btn)
		<div class="input-group-btn">
			{{ $prefix_btn }}
		</div>
	@endif

	@if(isset($password) && $password)
		{{ Form::password($name, array_merge(isset($attr) ? $attr : array(), array(
			'class' => 'form-control' . (isset($attr['class']) ? ' ' . $attr['class'] : ''),
		))) }}
	@else
		{{ Form::text($name, isset($value) ? $value : FALSE, array_merge(isset($attr) ? $attr : array(), array(
			'class' => 'form-control' . (isset($attr['class']) ? ' ' . $attr['class'] : ''),
		))) }}
	@endif

	@if(isset($suffix) && $suffix)
		<div class="input-group-addon">
			{{ $suffix }}
		</div>
	@endif

	@if(isset($suffix_btn) && $suffix_btn)
		<div class="input-group-btn">
			{{ $suffix_btn }}
		</div>
	@endif

	@if(isset($prefix) || isset($suffix) || isset($prefix_btn) || isset($suffix_btn))
		</div>
	@endif
@overwrite
