@extends('parties.record_wrapper')

@section('inner')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">@choice('labels.party_link', 0)</h4>
		</div>
			@if($party->links->count())
				<div class="list-group">
					@foreach($party->links as $l)
						<div class="list-group-item">
							{{{ $l->url }}}
						</div>
					@endforeach
				</div>
			@endif
		<div class="panel-footer">
			<div class="clearfix">
				<div class="pull-right">
					<div class="btn-group">
						<a href="{{ action('PartyLinkController@create', $party->id) }}" class="btn btn-primary">
							@lang('party_links.create')
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
