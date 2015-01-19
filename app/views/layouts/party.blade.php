@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="hidden-xs col-sm-5 col-md-4 col-lg-3 ">
			<img src="http://placehold.it/800x800" class="img-responsive img-rounded">
			<br>
			<p class="lead">
				{{ HTML::icon($party->icon) }}
				{{{ $party->name }}}
			</p>
			@include('parties.show_nav')
		</div>
		<div class="col-xs-12 col-sm-7 col-md-8 col-lg-9">
			{{ Form::open(array(
				'action' => array('PartyController@destroy', $party->id),
				'method' => 'DELETE',
			)) }}
			<h3 class="clearfix visible-xs">
				<img src="http://placehold.it/128x128" width="64" height="64" class="img-responsive img-rounded pull-left">
				<span class="visible-inline-xs">&nbsp;</span>
				{{ HTML::icon($party->icon) }}
				{{{ $party->name }}}
			</h3>
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
