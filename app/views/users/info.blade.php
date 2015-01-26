<dt>@lang('labels.created_at')</dt>
<dd>
	<abbr title="{{ $user->created_at->toDayDateTimeString()}}">
		{{ $user->created_at->diffForHumans() }}
	</abbr>
</dd>
