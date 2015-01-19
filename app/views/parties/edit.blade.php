@extends('layouts.party')

@section('inner')
	{{ Form::open(array(
		'action' => array('PartyController@update', $party->id),
		'method' => 'put',
	)) }}
	<div class="panel panel-default">
		<div class="panel-body">
			@include('parties.form')
			@include($party_type_form)
		</div>
		<div class="panel-footer">
			@include('forms.submit', array(
				'btns' => '<a href="' . action('PartyController@show', $party->id) . '" class="btn btn-default">' . Lang::get('labels.cancel') . '</a>'
			))
		</div>
	</div>
	{{ Form::close() }}
@stop
