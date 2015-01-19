@section('inner')
	<div class="panel panel-default">
		<div class="panel-body">
			<dl class="dl-horizontal">
				<dt>
					@lang('party_links.url')
				</dt>
				<dd>
					{{{ $link->url }}}
					<a class="btn btn-sm btn-link pull-right" href="{{{ $link->url }}}">
						{{ Lang::get('labels.visit_external') }}
						{{ HTML::icon('external-link') }}
					</a>
				</dd>
				@if($link->created_at->timestamp !== $link->updated_at->timestamp)
					<dt>@lang('labels.updated_at')</dt>
					<dd>
						<abbr title="{{ $link->updated_at->toDayDateTimeString()}}">
							{{ $link->updated_at->diffForHumans() }}
						</abbr>
					</dd>
				@endif
				<dt>@lang('labels.created_at')</dt>
				<dd>
					<abbr title="{{ $link->created_at->toDayDateTimeString()}}">
						{{ $link->created_at->diffForHumans() }}
					</abbr>
				</dd>
			</dl>
		</div>
		<div class="panel-footer clearfix">
			{{ Form::open(array(
				'action' => array('PartyLinkController@destroy', $party->id, $link->id),
				'method' => 'DELETE',
			)) }}
			<div class="pull-left">
				<div class="btn-group">
					<a href="{{ action('PartyLinkController@index', $party->id) }}" class="btn btn-default">
						@lang('labels.back')
					</a>
				</div>
			</div>
			<div class="pull-right">
				<div class="btn-group">
					<button type="submit" class="btn btn-danger">
						@lang('labels.destroy')
					</button>
					<a href="{{ action('PartyLinkController@edit', array($party->id, $link->id)) }}" class="btn btn-warning">
						@lang('labels.edit')
					</a>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
@stop
