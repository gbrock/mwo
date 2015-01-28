<dt>@choice('labels.usergroup', 0)</dt>
<dd>
	@if($user->groups->count())
		<ul class="list-inline">
			
		@foreach($user->groups as $g)
			<li><span class="label label-default">{{{ $g->name }}}</span></li>
		@endforeach
		</ul>
	@else
		<em>not set</em>
	@endif
</dd>

<dt>@lang('labels.created_at')</dt>
<dd>
	<abbr title="{{ $user->created_at->toDayDateTimeString()}}">
		{{ $user->created_at->diffForHumans() }}
	</abbr>
</dd>

