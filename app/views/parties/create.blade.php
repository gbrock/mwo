@extends('layouts.master')

@section('content')
	<p class="lead text-muted">
		<span class="fa fa-plus">&nbsp;</span>
		@lang('parties.create')
	</p>

	{{ Form::open(array(
		'action' => 'PartyController@store',
	)) }}
		@include('parties.choose_type')
	{{ Form::close() }}

	{{ Form::open(array(
		'action' => 'PartyController@store',
	)) }}
		<input type="hidden" name="type" value="{{ $party_type }}"></input>
		@include('parties.form')
		@include($party_type_form)
		@include('forms.submit')

	{{ Form::close() }}
@stop
