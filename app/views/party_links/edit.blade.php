@section('inner')
	{{ Form::open(array(
		'action' => array('PartyLinkController@update', $party->id, $link->id),
		'method' => 'put',
	)) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">@lang('party_links.edit', array('item' => '#' . $link->id))</h4>
		</div>
		<div class="panel-body">
			
			@include('party_links.form')

		</div>
		<div class="panel-footer">
			<div class="clearfix">
				<div class="pull-right">
					<div class="btn-group">
						<a href="{{ action('PartyLinkController@show', array($party->id, $link->id)) }}" class="btn btn-default">
							@lang('labels.cancel')
						</a>
						<button type="submit" name="save" class="btn btn-success">
							@lang('labels.save')
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{ Form::close() }}
@stop
