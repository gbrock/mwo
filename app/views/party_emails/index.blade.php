@section('inner')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">@choice('labels.party_email', 0)</h4>
		</div>
		@if($party->emails->count())
			<div class="list-group">
				@foreach($party->emails as $e)
					<a class="list-group-item" href="{{ action('PartyEmailController@show', array($party->id, $e->id)) }}">
						{{{ $e->address }}}
					</a>
				@endforeach
			</div>
			<div class="panel-footer">
				<div class="clearfix">
					<div class="pull-right">
						<div class="btn-group">
							<a href="{{ action('PartyEmailController@create', $party->id) }}" class="btn btn-primary">
								@lang('party_emails.create')
							</a>
						</div>
					</div>
				</div>
			</div>
		@else
			<div class="panel-body">
				<div class="alert alert-info">
					@lang('party_emails.empty_table')
					<a href="{{ action('PartyEmailController@create', $party->id) }}">
						@lang('party_emails.create_friendly')
						{{ HTML::icon('plus', 0) }}
					</a>
				</div>
			</div>
		@endif
	</div>
@stop
