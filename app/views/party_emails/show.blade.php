@section('inner')
	<div class="panel panel-default">
		<div class="panel-body">
			<dl class="dl-horizontal">
				<dt>
					@lang('party_emails.address')
				</dt>
				<dd>
					{{{ $email->address }}}
				</dd>
				@if($email->created_at->timestamp !== $email->updated_at->timestamp)
					<dt>@lang('labels.updated_at')</dt>
					<dd>
						<abbr title="{{ $email->updated_at->toDayDateTimeString()}}">
							{{ $email->updated_at->diffForHumans() }}
						</abbr>
					</dd>
				@endif
				<dt>@lang('labels.created_at')</dt>
				<dd>
					<abbr title="{{ $email->created_at->toDayDateTimeString()}}">
						{{ $email->created_at->diffForHumans() }}
					</abbr>
				</dd>
			</dl>
		</div>
		<div class="panel-footer clearfix">
			{{ Form::open(array(
				'action' => array('PartyEmailController@destroy', $party->id, $email->id),
				'method' => 'DELETE',
			)) }}
			<div class="pull-left">
				<div class="btn-group">
					<a href="{{ action('PartyEmailController@index', $party->id) }}" class="btn btn-default">
						@lang('labels.back')
					</a>
				</div>
			</div>
			<div class="pull-right">
				<div class="btn-group">
					<button type="submit" class="btn btn-danger">
						@lang('labels.destroy')
					</button>
					<a href="{{ action('PartyEmailController@edit', array($party->id, $email->id)) }}" class="btn btn-warning">
						@lang('labels.edit')
					</a>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
@stop
