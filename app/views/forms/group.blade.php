<?php

if(!isset($label))
{
	$label = FALSE;
}

if(!isset($value))
{
	$value = FALSE;
}

if(!isset($help_text))
{
	$help_text = FALSE;
}

?>
@if(!$errors->first($name))
<div class="form-group {{ $form_group_class or NULL }}">
@else
<div class="form-group has-error {{ $form_group_class or NULL }}">
@endif
	{{--  --}}
	@if($label)
		{{ Form::label($name, $label, array(
			'class' => 'control-label' . (isset($label_class) ? ' '.$label_class : ''),
		))}}
	@endif
	@if(isset($wrapper_class) && $wrapper_class)
	<div class="{{$wrapper_class}}">
	@endif
	@yield('control')
	@if($errors->first($name) || $help_text)
		<div class="help-block">
			{{ $errors->first($name) }}
			{{ $help_text }}
		</div>
	@endif
	@if(isset($wrapper_class) && $wrapper_class)
	</div>
	@endif
</div>
