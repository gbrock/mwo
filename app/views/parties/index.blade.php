<div class="pull-right btn-group btn-group-sm btn-group-for-header">
	<a class="btn btn-primary" href="{{ action('PartyController@create') }}">
		{{ HTML::icon('plus-circle') }}
		@lang('parties.create')
	</a>
</div>
<p class="lead text-muted">
	<span class="fa fa-book">&nbsp;</span>
	<strong>@choice('labels.party', 0)</strong>: 
	@lang('parties.description')
</p>

@if(count($records))

	<div class="list-group">
		@foreach ($records as $r)
			<a href="{{ action('PartyController@show', $r->id) }}" class="list-group-item">
				{{ HTML::icon($r->icon) }}
				{{{ $r->name }}}
			</a>
		@endforeach
	</div>
			
	{{ $records->appends( // use the current table GET variables (i.e. sorting)
		array(
			'sort' => Input::get('sort'),
			'dir' => Input::get('dir'),
		)
	)->links() }}

@else
	<div class="alert alert-info">
		@lang('parties.empty_table')
		<a href="{{ action('PartyController@create') }}">
			@lang('parties.create_friendly')
			{{ HTML::icon('plus', 0) }}
		</a>
	</div>
@endif
