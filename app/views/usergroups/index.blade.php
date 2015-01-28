<div class="pull-right btn-group btn-group-sm btn-group-for-header">
	<a class="btn btn-primary" href="{{ action('UserGroupController@create') }}">
		{{ HTML::icon('plus-circle') }}
		@lang('usergroups.create')
	</a>
</div>
<p class="lead text-muted">
	<span class="fa fa-user">&nbsp;</span>
	<strong>@choice('labels.usergroup', 0)</strong>: 
	@lang('usergroups.description_friendly')
</p>

@if($groups)
	<div class="list-group">
	@foreach($groups as $g)
		<a class="list-group-item" href="{{ action('UserGroupController@show', array($g->id)) }}">
			{{{  $g->name  }}}
		</a>
	@endforeach
	</div>
@else
	<div class="alert alert-info">
		@lang('usergroups.empty_table')
		<a href="{{ action('UserGroupController@create') }}">
			@lang('usergroups.create_friendly')
			{{ HTML::icon('plus', 0) }}
		</a>
	</div>
@endif
