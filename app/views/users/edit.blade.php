{{ Form::open(array(
	'action' => array('UserController@update', $party->id, $user->id),
	'method' => 'put',
)) }}
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">@lang('labels.edit_item', array('item' => Lang::choice('labels.account', 1)))</h4>
	</div>
	<div class="panel-body">
		@include('users.form')
	</div>
	<div class="panel-footer">
		@include('forms.submit', array(
			'btns' => '<a href="' . action('UserController@show', $party->id) . '" class="btn btn-default">' . Lang::get('labels.cancel') . '</a>',
			'label' => Lang::get('labels.save'),
		))
	</div>
</div>
{{ Form::close() }}
