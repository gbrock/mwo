<div class="pull-right btn-group btn-group-sm">
	<a class="btn btn-primary" href="{{ action('PageController@create') }}">
		{{ HTML::icon('plus-circle') }}
		@lang('pages.create')
	</a>
</div>
<p class="lead text-muted">
	{{ HTML::icon('file-text-o') }}
	<strong>@choice('labels.page', 0)</strong>: 
	@lang('pages.description')
</p>


@if(count($records))

	<div class="list-group">
		@foreach ($records as $r)
			<a href="{{ action('PageController@show', $r->url) }}" class="list-group-item">
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
		@lang('pages.empty_table')
		<a href="{{ action('PageController@create') }}">
			@lang('pages.create_friendly')
			{{ HTML::icon('plus', 0) }}
		</a>
	</div>
@endif
