@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-sm-3 col-lg-2">
			<object type="image/svg+xml" data="{{ asset('includes/img/avatar.svg') }}" class="img-responsive img-rounded thumbnail">
			</object>
			<br>
			<p class="lead">
				{{ HTML::icon($party->icon) }}
				{{{ $party->name }}}
			</p>
			{{ $partyMenu->asUl(array('class' => 'nav nav-pills nav-stacked hidden-xs')) }}
		</div>
		<div class="col-xs-12 col-sm-9 col-lg-10">
			
			{{ $rendered_view or '' }}
			
			<div class="visible-xs">
				<hr>
				<em>@lang('labels.see_also', array('item' => $party->name))</em>
				{{ $partyMenu->asUl(array('class' => 'nav nav-pills')) }}
			</div>
		</div>
	</div>
@stop
