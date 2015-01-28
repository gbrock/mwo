@extends('forms.group')

@section('control')
	@if(isset($options) && count($options) > 0)
		<div>
			<div class="btn-group{{ isset($btn_group_class) ? ' ' . $btn_group_class : '' }}" data-toggle="buttons">
				@foreach($options as $k => $v)
					<label class="radio-inline">
						{{ Form::radio($name, $k, (isset($value) && $k == $value)) . $v }} 
					</label>
				@endforeach
			</div>
		</div>
	@endif
@overwrite
