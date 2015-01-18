@extends('html5')

@section('body')
	<div class="container">
		@section('breadcrumbs')
			@if(isset($crumbs))
				{{ $crumbs }}
			@endif
		@show
		@yield('content')
	</div>
@stop
