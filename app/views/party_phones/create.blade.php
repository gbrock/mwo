@section('inner')
	{{ Form::open(array(
		'action' => array('PartyPhoneController@store', $party->id),
	)) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">@lang('party_phones.create')</h4>
		</div>
		<div class="panel-body">
			
			@include('party_phones.form')

		</div>
		<div class="panel-footer">
			<div class="clearfix">
				<div class="pull-right">
					<div class="btn-group">
						<a href="{{ action('PartyPhoneController@index', $party->id) }}" class="btn btn-default">
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
