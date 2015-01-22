@include('forms.input', array(
	'name' => 'password',
	'password' => TRUE,
	'label' => Lang::get('auth.password'),
))

@include('forms.input', array(
	'name' => 'password_confirmation',
	'password' => TRUE,
	'label' => Lang::get('labels.please_confirm', array('field' => Lang::get('auth.password'))),
))

