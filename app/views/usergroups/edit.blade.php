{{ Form::open(array(
	'action' => array('UserGroupController@update', $group->id),
	'method' => 'put',
)) }}

@include('usergroups.form', array('group' => $group))
@include('forms.submit', array(
	'btns' => '<a href="' . action("UserGroupController@show", array($group->id)) . '" class="btn btn-default">
						' . Lang::get('labels.cancel') . '
					</a>',
))

{{ Form::close() }}
