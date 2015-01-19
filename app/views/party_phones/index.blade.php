@section('inner')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">@choice('labels.party_phone', 0)</h4>
		</div>
		@if($party->phones->count())
			<div class="list-group">
				@foreach($party->phones as $p)
					<a class="list-group-item" href="{{ action('PartyPhoneController@show', array($party->id, $p->id)) }}">
						{{{ $p->number }}}
					</a>
				@endforeach
			</div>
			<div class="panel-footer">
				<div class="clearfix">
					<div class="pull-right">
						<div class="btn-group">
							<a href="{{ action('PartyPhoneController@create', $party->id) }}" class="btn btn-primary">
								@lang('party_phones.create')
							</a>
						</div>
					</div>
				</div>
			</div>
		@else
			<div class="panel-body">
				<div class="alert alert-info">
					@lang('party_phones.empty_table')
					<a href="{{ action('PartyPhoneController@create', $party->id) }}">
						@lang('party_phones.create_friendly')
						{{ HTML::icon('plus', 0) }}
					</a>
				</div>
			</div>
		@endif
	</div>
@stop
