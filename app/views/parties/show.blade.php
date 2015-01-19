<div class="panel panel-default">
	<div class="panel-body">
		{{ Form::open(array(
			'action' => array('PartyController@destroy', $party->id),
			'method' => 'DELETE',
		)) }}
		<div class="btn-group btn-group-xs">
			<a href="{{ action('PartyController@edit', array($party->id)) }}" class="btn btn-link">
				<i class="fa fa-edit">&nbsp;</i>
				@lang('labels.edit')
			</a>
			<button type="submit" class="btn btn-link">
				<i class="fa fa-trash">&nbsp;</i>
				@lang('labels.destroy')
			</button>
		</div>
		{{ Form::close() }}
		<br>
		<br>
		<dl class="dl-horizontal">
			<dt>
				@lang('parties.id')
			</dt>
			<dd>
				# {{ $party->id }}
			</dd>
			<dt>
				@lang('parties.name')
			</dt>
			<dd>
				{{{ $party->name }}}
			</dd>
			@if($party->isPerson())
				@include('people.info')
			@endif

			@if($party->isOrganization())
				@include('organizations.info')
			@endif
			@if($party->created_at->timestamp !== $party->updated_at->timestamp)
				<dt>@lang('labels.updated_at')</dt>
				<dd>
					<abbr title="{{ $party->updated_at->toDayDateTimeString()}}">
						{{ $party->updated_at->diffForHumans() }}
					</abbr>
				</dd>
			@endif
			<dt>@lang('labels.created_at')</dt>
			<dd>
				<abbr title="{{ $party->created_at->toDayDateTimeString()}}">
					{{ $party->created_at->diffForHumans() }}
				</abbr>
			</dd>
		</dl>
	</div>
</div>
