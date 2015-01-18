@extends('layouts.master')

@section('content')
	<p class="lead text-muted">
		<span class="fa fa-wrench">&nbsp;</span>
		@lang('parties.edit', array('item' => $party->name))
	</p>

	{{ Form::open(array(
		'action' => array('PartyController@update', $party->id),
		'method' => 'put',
	)) }}
		@include('parties.form')
		@include($party_type_form)
		@include('forms.submit', array(
			'btns' => '<a href="' . action('PartyController@show', $party->id) . '" class="btn btn-default">' . Lang::get('labels.cancel') . '</a>'
		))

	{{ Form::close() }}
@stop
