@extends('html5')

@section('body')
	<nav class="navbar navbar-static-top navbar-inverse">
		<div class="container">
			<a href="{{ url() }}" class="navbar-brand">
				MWO
			</a>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li{{ $active_controller === 'PartyController' ? ' class="active"' : '' }}>
						<a href="{{ action('PartyController@index') }}">
							@choice('labels.party', 0)
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		@section('breadcrumbs')
			@if(isset($crumbs))
				{{ $crumbs }}
			@endif
		@show
		{{ Notification::showAll() }}
		@yield('content')
	</div>
@stop
