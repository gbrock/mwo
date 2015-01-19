<?php

// The home crumb
Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push(Lang::get('labels.home'), url(''));
});

// Any action with a parent
Breadcrumbs::register('action', function($breadcrumbs, $action, $parent, $parent_vars = array()) {
    call_user_func_array(array($breadcrumbs, 'parent'), array_merge(array($parent), is_array($parent_vars) ? $parent_vars : array($parent_vars)));
    $breadcrumbs->push($action);
});

// The directory
Breadcrumbs::register('parties', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(Lang::choice('labels.party', 0), action('PartyController@index'));
});

// A directory record
Breadcrumbs::register('party', function($breadcrumbs, $party) {
    $breadcrumbs->parent('parties');
    $breadcrumbs->push($party->name, action('PartyController@show', $party->id));
});

Breadcrumbs::register('party_links', function($breadcrumbs, $party) {
	$breadcrumbs->parent('party', $party);
    $breadcrumbs->push(Lang::choice('labels.party_link', 0), action('PartyLinkController@index', $party->id));
});

Breadcrumbs::register('party_link', function($breadcrumbs, $party, $link) {
	$breadcrumbs->parent('party_links', $party);
    $breadcrumbs->push('#' . $link->id, action('PartyLinkController@show', array($party->id, $link->id)));
});

Breadcrumbs::register('party_emails', function($breadcrumbs, $party) {
    $breadcrumbs->parent('party', $party);
    $breadcrumbs->push(Lang::choice('labels.party_email', 0), action('PartyEmailController@index', $party->id));
});

Breadcrumbs::register('party_email', function($breadcrumbs, $party, $email) {
    $breadcrumbs->parent('party_emails', $party);
    $breadcrumbs->push('#' . $email->id, action('PartyEmailController@show', array($party->id, $email->id)));
});

Breadcrumbs::register('party_phones', function($breadcrumbs, $party) {
    $breadcrumbs->parent('party', $party);
    $breadcrumbs->push(Lang::choice('labels.party_phone', 0), action('PartyPhoneController@index', $party->id));
});

Breadcrumbs::register('party_phone', function($breadcrumbs, $party, $phone) {
    $breadcrumbs->parent('party_phones', $party);
    $breadcrumbs->push('#' . $phone->id, action('PartyPhoneController@show', array($party->id, $phone->id)));
});
