@extends('forms.group')

@section('control')
	@if(isset($options) && count($options) > 0)
		<div>
			@foreach($options as $k => $v)
				<label class="checkbox">
					{{ Form::checkbox($name, $k, (isset($value) ? $k == $value || in_array($k, $value) : FALSE)) . $v }} 
				</label>
			@endforeach
		</div>
	@endif
@overwrite
