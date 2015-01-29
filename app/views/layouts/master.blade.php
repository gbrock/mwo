@extends('layouts.html5')

@section('title')
	{{{ isset($page_title) && $page_title ? $page_title . ' &ndash; ' : '' }}}
	@lang('titles.site')
@stop

@section('body')
	<nav class="navbar navbar-static-top navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="{{ url() }}" class="navbar-brand">
					@lang('titles.site')
				</a>
			</div>
			<div class="collapse navbar-collapse">
				{{ $mainMenu->asUl(array('class' => 'nav navbar-nav')) }}
				{{ $userMenu->asUl(array('class' => 'nav navbar-nav navbar-right')) }}
			</div>
		</div>
	</nav>
	<div class="container">
		@section('breadcrumbs')
			@if(isset($crumbs))
				{{ $crumbs }}
			@endif
		@show
		<div class="blink-awake">
			{{ Notification::showAll() }}
		</div>
		@section('content')
			{{ $rendered_view or '' }}
		@show
	</div>
@stop
