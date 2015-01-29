@extends('layouts.master')


@section('body')
	<nav class="navbar navbar-static-top navbar-inverse">
		<div class="container-fluid">
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
				{{ $userMenu->asUl(array('class' => 'nav navbar-nav navbar-right')) }}
			</div>
		</div>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-md-2 admin-sidebar hidden-xs">
				{{ $adminMenu->asUl(array('class' => 'nav nav-pills nav-stacked')) }}
			</div>
			<div class="col-sm-9 col-md-10">
				@section('breadcrumbs')
					@if(isset($crumbs))
						<div class="admin-crumbs">
							{{ $crumbs }}
						</div>
					@endif
				@show
				<div class="blink">
					{{ Notification::showAll() }}
				</div>
				@section('content')
					{{ $rendered_view or '' }}
				@show
			</div>
		</div>
	</div>
@stop
