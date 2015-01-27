<p class="lead text-muted">
	{{ HTML::icon('user') }}
	@lang('titles.register')
</p>

{{ Form::open(array(
	'action' => 'AuthController@store',
)) }}
	@include('parties.form')
	@include('party_emails.form', array(
		'label' => Lang::choice('labels.party_email', 1),
	))
	@include('auth.form')
	@include('forms.submit', array(
		'label' => HTML::icon('lock') . Lang::get('auth.register_now'),
	))
{{ Form::close() }}
