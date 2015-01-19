<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">@choice('labels.party_' . $data_key, 0)</h4>
	</div>
	@if($items->count())
		<div class="list-group">
			@foreach($items as $i)
				<a class="list-group-item" href="{{ action("$controller@show", array($party->id, $i->id)) }}">
					{{{ $i->label }}}
				</a>
			@endforeach
		</div>
		<div class="panel-footer">
			<div class="clearfix">
				<div class="pull-right">
					<div class="btn-group">
						<a href="{{ action($controller . '@create', $party->id) }}" class="btn btn-primary">
							@lang('party_' . $data_key_p . '.create')
						</a>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="panel-body">
			<div class="alert alert-info">
				@lang('party_' . $data_key_p . '.empty_table')
				<a href="{{ action($controller . '@create', $party->id) }}">
					@lang('party_' . $data_key_p . '.create_friendly')
					{{ HTML::icon('plus', 0) }}
				</a>
			</div>
		</div>
	@endif
</div>
