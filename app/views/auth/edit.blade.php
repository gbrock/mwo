<p class="lead text-muted">
	{{ HTML::icon('user') }}
	@lang('labels.edit_item', array('item' => Lang::get('auth.my_account')))
</p>

{{ Form::open(array(
	'action' => 'AuthController@update',
	'method' => 'put',
)) }}
	@include('parties.form')
	{{-- @include('people.form')
	@include('party_emails.form', array(
		'label' => Lang::choice('labels.party_email', 1),
	))
	@include('party_phones.form', array(
		'label' => Lang::choice('labels.party_phone', 1),
	))
	@include('party_addresses.form', array(
		'label' => Lang::choice('labels.party_address', 1),
	))
	@include('party_links.form', array(
		'label' => Lang::choice('labels.party_link', 1),
	))
	--}}
	@include('auth.form')
	@include('forms.submit', array(
		'label' => Lang::get('labels.save'),
	))
{{ Form::close() }}
