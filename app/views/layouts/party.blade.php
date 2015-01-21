@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-sm-3 col-lg-2">
			<object type="image/svg+xml" data="{{ asset('includes/img/avatar.svg') }}" class="img-responsive img-rounded">
			</object>
			<br>
			<p class="lead">
				{{ HTML::icon($party->icon) }}
				{{{ $party->name }}}
			</p>
			<div class="hidden-xs">
				@include('parties.show_nav')
			</div>
		</div>
		<div class="col-xs-12 col-sm-9 col-lg-10">
			{{ Form::open(array(
				'action' => array('PartyController@destroy', $party->id),
				'method' => 'DELETE',
			)) }}
			{{ Form::close() }}
			
			{{ $rendered_view or '' }}
			
			<div class="visible-xs">
				<hr>
				<em>@lang('labels.see_also', array('item' => $party->name))</em>
				@include('parties.show_nav', array(
					'nav_class' => 'nav-pills',
				))
			</div>
		</div>
	</div>
@stop
