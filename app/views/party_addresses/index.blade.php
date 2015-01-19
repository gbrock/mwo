@section('inner')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">@choice('labels.party_address', 0)</h4>
		</div>
		@if($party->addresses->count())
			<div class="list-group">
				@foreach($party->addresses as $a)
					<a class="list-group-item" href="{{ action('PartyAddressController@show', array($party->id, $a->id)) }}">
						{{{ $a->provided_as }}}
					</a>
				@endforeach
			</div>
			<div class="panel-footer">
				<div class="clearfix">
					<div class="pull-right">
						<div class="btn-group">
							<a href="{{ action('PartyAddressController@create', $party->id) }}" class="btn btn-primary">
								@lang('party_addresses.create')
							</a>
						</div>
					</div>
				</div>
			</div>
		@else
			<div class="panel-body">
				<div class="alert alert-info">
					@lang('party_addresses.empty_table')
					<a href="{{ action('PartyAddressController@create', $party->id) }}">
						@lang('party_addresses.create_friendly')
						{{ HTML::icon('plus', 0) }}
					</a>
				</div>
			</div>
		@endif
	</div>
@stop
