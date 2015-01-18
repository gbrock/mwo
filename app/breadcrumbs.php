<?php

// The home crumb
Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push('Home', url(''));
});

// Any action with a parent
Breadcrumbs::register('action', function($breadcrumbs, $action, $parent, $parent_vars = array()) {
    call_user_func_array(array($breadcrumbs, 'parent'), array_merge(array($parent), is_array($parent_vars) ? $parent_vars : array($parent_vars)));
    $breadcrumbs->push($action);
});

// The directory
Breadcrumbs::register('parties', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Parties', action('PartyController@index'));
});

// A directory record
Breadcrumbs::register('party', function($breadcrumbs, $party) {
    $breadcrumbs->parent('parties');
    $breadcrumbs->push($party->name, action('PartyController@show', $party->id));
});
