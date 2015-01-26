@include('forms.input', array(
	'name' => 'password',
	'label' => Lang::get('auth.set_password'),
))

@if($user)
	@include('forms.checkbox', array(
		'name' => 'user',
		'options' => array(
			'banned' => Lang::get('auth.user_is_banned', array(
				'user' => ($user ? $user->party->name : Lang::choice('labels.user', 1)),
			)),
		),
		'value' => ($user && $user->deleted_at ? array('banned') : array()),
	))
@endif
