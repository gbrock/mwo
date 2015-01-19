@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="hidden-xs col-sm-5 col-md-4 col-lg-3 ">
			<img src="http://placehold.it/800x800" class="img-responsive img-rounded">
			<br>
			@include('parties.show_nav')
			<br>
			<div class="well well-sm small text-muted">
				@lang('parties.id') <strong class="pull-right">#{{ $party->id }}</strong>
				<br>
				@if($party->created_at->timestamp !== $party->updated_at->timestamp)
					@lang('labels.updated_at') <strong class="pull-right">
						<abbr title="{{ $party->updated_at->toDayDateTimeString()}}">
							{{ $party->updated_at->diffForHumans() }}
						</abbr>
					</strong>
					<br>
				@endif
				@lang('labels.created_at') <strong class="pull-right">
					<abbr title="{{ $party->created_at->toDayDateTimeString()}}">
						{{ $party->created_at->diffForHumans() }}
					</abbr>
				</strong>
			</div>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-8 col-lg-9">
			{{ Form::open(array(
				'action' => array('PartyController@destroy', $party->id),
				'method' => 'DELETE',
			)) }}
			<h3 class="clearfix">
				<img src="http://placehold.it/128x128" width="64" height="64" class="img-responsive img-rounded visible-xs pull-left">
				<span class="visible-inline-xs">&nbsp;</span>
				{{ HTML::icon($party->icon) }}
				{{{ $party->name }}}
			</h3>
			{{ Form::close() }}
			
			@yield('inner')
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
