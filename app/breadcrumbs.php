<?php

// The home crumb
Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push(Lang::get('titles.home'), url(''));
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

Breadcrumbs::register('party', function($breadcrumbs, $party) {
    $breadcrumbs->parent('parties');
    $breadcrumbs->push($party->name, action('PartyController@show', $party->id));
});

// The emails, phones, links, and addresses associated with a directory record
Breadcrumbs::register('party_locators', function($breadcrumbs, $locator_name, $party) {
    $breadcrumbs->parent('party', $party);
    $breadcrumbs->push(Lang::choice('labels.party_' . $locator_name, 0), action('Party' . ucfirst($locator_name) . 'Controller@index', $party->id));
});

Breadcrumbs::register('party_locator', function($breadcrumbs, $locator_name, $party, $locator) {
    $breadcrumbs->parent('party_locators', $locator_name, $party);
    $breadcrumbs->push('#' . $locator->id, action('Party' . ucfirst($locator_name) . 'Controller@show', array($party->id, $locator->id)));
});

// Usergroups
Breadcrumbs::register('usergroups', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(Lang::choice('labels.usergroup', 0), action('UserGroupController@index'));
});

Breadcrumbs::register('usergroup', function($breadcrumbs, $group) {
    $breadcrumbs->parent('usergroups');
    $breadcrumbs->push($group->name, action('UserGroupController@show', $group->id));
});

// Pages
Breadcrumbs::register('pages', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(Lang::choice('labels.page', 0), action('PageController@index'));
});

Breadcrumbs::register('page', function($breadcrumbs, $page) {
    $breadcrumbs->parent('pages');
    $breadcrumbs->push($page->name, action('PageController@show', $page->url));
});
