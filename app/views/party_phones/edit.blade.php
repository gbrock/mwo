@section('inner')
	{{ Form::open(array(
		'action' => array('PartyPhoneController@update', $party->id, $phone->id),
		'method' => 'put',
	)) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">@lang('party_phones.edit', array('item' => '#' . $phone->id))</h4>
		</div>
		<div class="panel-body">
			
			@include('party_phones.form')

		</div>
		<div class="panel-footer">
			<div class="clearfix">
				<div class="pull-right">
					<div class="btn-group">
						<a href="{{ action('PartyPhoneController@show', array($party->id, $phone->id)) }}" class="btn btn-default">
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
