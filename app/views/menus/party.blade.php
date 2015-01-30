<?php
/**
 * NOTE: Having raw PHP in a Blade file feels wrong, but menu logic seems best 
 * suited to a view file.
 */

/**
 * Initiate a new menu from lavary/laravel-menu
 * @var Menu
 */
$menu = Menu::make('newPartyMenu', function(){});

/**
 * Add the items one-by-one the the menu, setting active() wherever there are
 * subpages which require the item to continue to appear active.
 */

// The overview (index)
$menu->add(
	HTML::icon($party->icon . ' fa-fw') . Lang::get('labels.overview'),
	array(
		'action' => array('PartyController@show', $party->id),
	)
)->active('party/([0-9]*)/edit'); // active on this route

 // The user page
$menu->add(
	HTML::icon('key fa-fw') . Lang::choice('labels.account', 1),
	array(
		'action' => array('UserController@show', $party->id),
	)
)->active('party/([0-9]*)/user/*'); // active on this route


/**
 * The locators
 */

	// Links
	$menu->add(
		(
			$party->links()->count() ? 
			'<span class="badge pull-right">' . number_format($party->links()->count()) . '</span>' : 
			''
		) . HTML::icon('link fa-fw') . Lang::choice('labels.party_link', 0),
		array(
			'action' => array('PartyLinkController@index', $party->id),
		)
	)->active('party/([0-9]*)/links/*'); // active on these routes

	// E-mails
	$menu->add(
		(
			$party->emails()->count() ? 
			'<span class="badge pull-right">' . number_format($party->emails()->count()) . '</span>' : 
			''
		) . HTML::icon('envelope-o fa-fw') . Lang::choice('labels.party_email', 0),
		array(
			'action' => array('PartyEmailController@index', $party->id),
		)
	)->active('party/([0-9]*)/emails/*'); // active on these routes

	// Phones
	$menu->add(
		(
			$party->phones()->count() ? 
			'<span class="badge pull-right">' . number_format($party->phones()->count()) . '</span>' : 
			''
		) . HTML::icon('phone fa-fw') . Lang::choice('labels.party_phone', 0),
		array(
			'action' => array('PartyPhoneController@index', $party->id),
		)
	)->active('party/([0-9]*)/phones/*'); // active on these routes

	// Addresses
	$menu->add(
		(
			$party->addresses()->count() ? 
			'<span class="badge pull-right">' . number_format($party->addresses()->count()) . '</span>' : 
			''
		) . HTML::icon('map-marker fa-fw') . Lang::choice('labels.party_address', 0),
		array(
			'action' => array('PartyAddressController@index', $party->id),
		)
	)->active('party/([0-9]*)/addresses/*'); // active on these routes

?>
@if(!isset($mobile) || !$mobile)
	{{ $menu->asUl(array('class' => 'nav nav-pills nav-stacked hidden-xs')) }}
@else
	<div class="visible-xs">
		<hr>
		<em>@lang('labels.see_also', array('item' => $party->name))</em>
		{{ $menu->asUl(array('class' => 'nav nav-pills')) }}
	</div>
@endif
