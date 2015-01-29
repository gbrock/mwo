@extends('forms.group')

@section('control')

	{{ Form::file($name, isset($attr) ? $attr : array()) }}

@overwrite
