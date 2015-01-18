@extends('forms.group')

@section('control')
	{{ Form::textarea($name, isset($value) ? $value : FALSE, array_merge(isset($attr) ? $attr : array(), array(
		'class' => 'form-control' . (isset($attr['class']) ? ' ' . $attr['class'] : ''),
	))) }}
@overwrite
