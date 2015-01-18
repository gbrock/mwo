@extends('forms.group')

@section('control')
	@if(isset($options) && count($options) > 0)
		<div>
			<div class="btn-group{{ isset($btn_group_class) ? ' ' . $btn_group_class : '' }}" data-toggle="buttons">
				@foreach($options as $k => $v)
					<label class="btn btn-{{ isset($btn_class) ? $btn_class : 'default' }}">
						{{ Form::radio($name, $k, ($k == $value)) . $v }} 
					</label>
				@endforeach
			</div>
		</div>
	@endif
@overwrite
