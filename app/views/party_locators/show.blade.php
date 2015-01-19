<div class="panel panel-default">
	<div class="panel-body">
		<dl class="dl-horizontal">
			@include('party_' . $data_key_p . '.info')
			@if($target->created_at->timestamp !== $target->updated_at->timestamp)
				<dt>@lang('labels.updated_at')</dt>
				<dd>
					<abbr title="{{ $target->updated_at->toDayDateTimeString()}}">
						{{ $target->updated_at->diffForHumans() }}
					</abbr>
				</dd>
			@endif
			<dt>@lang('labels.created_at')</dt>
			<dd>
				<abbr title="{{ $target->created_at->toDayDateTimeString()}}">
					{{ $target->created_at->diffForHumans() }}
				</abbr>
			</dd>
		</dl>
	</div>
	<div class="panel-footer clearfix">
		{{ Form::open(array(
			'action' => array($controller . '@destroy', $party->id, $target->id),
			'method' => 'DELETE',
		)) }}
		<div class="pull-left">
			<div class="btn-group">
				<a href="{{ action($controller . '@index', $party->id) }}" class="btn btn-default">
					@lang('labels.back')
				</a>
			</div>
		</div>
		<div class="pull-right">
			<div class="btn-group">
				<button type="submit" class="btn btn-danger">
					@lang('labels.destroy')
				</button>
				<a href="{{ action($controller . '@edit', array($party->id, $target->id)) }}" class="btn btn-warning">
					@lang('labels.edit')
				</a>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>
