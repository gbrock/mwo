
{{ Form::open(array(
	'action' => 'AuthController@authenticate',
)) }}

@include('forms.input', array(
	'name' => 'username',
	'label' => Lang::get('auth.provide_username'),
	'attr' => array(
		'autofocus',
	),
))

@include('forms.input', array(
	'name' => 'password',
	'password' => TRUE,
	'label' => Lang::get('auth.provide_password'),
	'attr' => array(
	),
))

@include('forms.checkbox', array(
	'name' => 'remember',
	'options' => array(
		1 => Lang::get('auth.remember_me'),
	),
))

@include('forms.submit', array(
	'label' => Lang::get('auth.login_now'),
))

{{ Form::close() }}
