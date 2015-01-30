@extends('layouts.admin')

@section('content')
	<div class="row">
		<div class="col-sm-3 col-lg-2">
			<div class="thumbnail">
				@if($party->user && $party->user->avatar_file_name)
					<img src="{{ asset($party->user->avatar->url('medium')) }}" class="img-responsive">
				@else
					<object type="image/svg+xml" data="{{ asset('includes/img/avatar.svg') }}"></object>
				@endif
				<div class="caption">
					<h4>
						{{ HTML::icon($party->icon) }}
						{{{ $party->name }}}
					</h4>
				</div>
			</div>
			@include('menus.party')
		</div>
		<div class="col-xs-12 col-sm-9 col-lg-10">
			
			{{ $rendered_view or '' }}

			@include('menus.party', array(
				'mobile' => TRUE
			))
		</div>
	</div>
@stop
