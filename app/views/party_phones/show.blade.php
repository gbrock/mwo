@section('inner')
	<div class="panel panel-default">
		<div class="panel-body">
			<dl class="dl-horizontal">
				<dt>
					@lang('party_phones.number')
				</dt>
				<dd>
					{{{ $phone->number }}}
				</dd>
				<dt>
					@lang('party_phones.extension')
				</dt>
				<dd>
					{{{ $phone->extension or '&mdash;' }}}
				</dd>
				<dt>
					@lang('party_phones.type')
				</dt>
				<dd>
					{{{ $phone->type or '&mdash;' }}}
				</dd>
				@if($phone->created_at->timestamp !== $phone->updated_at->timestamp)
					<dt>@lang('labels.updated_at')</dt>
					<dd>
						<abbr title="{{ $phone->updated_at->toDayDateTimeString()}}">
							{{ $phone->updated_at->diffForHumans() }}
						</abbr>
					</dd>
				@endif
				<dt>@lang('labels.created_at')</dt>
				<dd>
					<abbr title="{{ $phone->created_at->toDayDateTimeString()}}">
						{{ $phone->created_at->diffForHumans() }}
					</abbr>
				</dd>
			</dl>
		</div>
		<div class="panel-footer clearfix">
			{{ Form::open(array(
				'action' => array('PartyPhoneController@destroy', $party->id, $phone->id),
				'method' => 'DELETE',
			)) }}
			<div class="pull-left">
				<div class="btn-group">
					<a href="{{ action('PartyPhoneController@index', $party->id) }}" class="btn btn-default">
						@lang('labels.back')
					</a>
				</div>
			</div>
			<div class="pull-right">
				<div class="btn-group">
					<button type="submit" class="btn btn-danger">
						@lang('labels.destroy')
					</button>
					<a href="{{ action('PartyPhoneController@edit', array($party->id, $phone->id)) }}" class="btn btn-warning">
						@lang('labels.edit')
					</a>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
@stop
