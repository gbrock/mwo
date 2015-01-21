@extends('layouts.html5')

@section('title')
	{{{ isset($page_title) && $page_title ? $page_title . ' &ndash; ' : '' }}}
	@lang('labels.site')
@stop

@section('body')
	<nav class="navbar navbar-static-top navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="{{ url() }}" class="navbar-brand">
					@lang('labels.site')
				</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li{{ $active_controller === 'PartyController' ? ' class="active"' : '' }}>
						<a href="{{ action('PartyController@index') }}">
							@choice('labels.party', 0)
						</a>
					</li>
				</ul>
				<div class="navbar-right"> {{-- Bad form to not use .navbar-right, but there's a negative margin involved with that and this solution floats it right on mobile too (kinda nice-looking) --}}
					@if(Sentry::check())
						<a class="btn navbar-btn btn-danger" href="{{ action('AuthController@logout') }}">
							@lang('labels.logout')
						</a>
					@else
						<ul class="nav navbar-nav">
							<li>
								<a href="{{ action('AuthController@create') }}">
									@lang('labels.register')
								</a>
							</li>
						</ul>
						<a class="btn navbar-btn btn-primary" href="{{ action('AuthController@login') }}">
							@lang('labels.login')
						</a>
					@endif
				</div>
			</div>
		</div>
	</nav>
	<div class="container">
		@section('breadcrumbs')
			@if(isset($crumbs))
				{{ $crumbs }}
			@endif
		@show
		<div class="blink">
			{{ Notification::showAll() }}
		</div>
		@section('content')
			{{ $rendered_view or '' }}
		@show
	</div>
@stop
