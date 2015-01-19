@section('inner')
	{{ Form::open(array(
		'action' => array('PartyEmailController@update', $party->id, $email->id),
		'method' => 'put',
	)) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">@lang('party_emails.edit', array('item' => '#' . $email->id))</h4>
		</div>
		<div class="panel-body">
			
			@include('party_emails.form')

		</div>
		<div class="panel-footer">
			<div class="clearfix">
				<div class="pull-right">
					<div class="btn-group">
						<a href="{{ action('PartyEmailController@show', array($party->id, $email->id)) }}" class="btn btn-default">
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
