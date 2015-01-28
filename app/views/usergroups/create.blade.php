{{ Form::open(array(
	'action' => 'UserGroupController@store',
)) }}

@include('usergroups.form')
@include('forms.submit')

{{ Form::close() }}
