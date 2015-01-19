@section('inner')
	<div class="panel panel-default">
		<div class="panel-body">
			<dl class="dl-horizontal">
				<dt>
					@lang('party_addresses.provided_as')
				</dt>
				<dd>
					{{{ $address->provided_as }}}
				</dd>
				<dt>
					@lang('party_addresses.type')
				</dt>
				<dd>
					{{{ $address->type }}}
				</dd>
				@if($address->created_at->timestamp !== $address->updated_at->timestamp)
					<dt>@lang('labels.updated_at')</dt>
					<dd>
						<abbr title="{{ $address->updated_at->toDayDateTimeString()}}">
							{{ $address->updated_at->diffForHumans() }}
						</abbr>
					</dd>
				@endif
				<dt>@lang('labels.created_at')</dt>
				<dd>
					<abbr title="{{ $address->created_at->toDayDateTimeString()}}">
						{{ $address->created_at->diffForHumans() }}
					</abbr>
				</dd>
			</dl>
		</div>
		<div class="panel-footer clearfix">
			{{ Form::open(array(
				'action' => array('PartyAddressController@destroy', $party->id, $address->id),
				'method' => 'DELETE',
			)) }}
			<div class="pull-left">
				<div class="btn-group">
					<a href="{{ action('PartyAddressController@index', $party->id) }}" class="btn btn-default">
						@lang('labels.back')
					</a>
				</div>
			</div>
			<div class="pull-right">
				<div class="btn-group">
					<button type="submit" class="btn btn-danger">
						@lang('labels.destroy')
					</button>
					<a href="{{ action('PartyAddressController@edit', array($party->id, $address->id)) }}" class="btn btn-warning">
						@lang('labels.edit')
					</a>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
@stop
