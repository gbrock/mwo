<?php

$active_action = (isset($active_action) ? $active_action : Route::currentRouteAction());

$party_nav_items = array();

$party_nav_items[] = array(
	'action' => 'PartyController@show',
	'action_param' => array($party->id),
	'icon' => $party->icon,
	'label' => Lang::get('labels.overview'),
);

$party_nav_items[] = array(
	'action' => 'PartyLinkController@index',
	'action_param' => array($party->id),
	'icon' => 'link',
	'label' => ($party->links()->count() ? '<span class="badge pull-right">' . number_format($party->links()->count()) . '</span>' : '') . Lang::choice('labels.party_link', 0),
);

$party_nav_items[] = array(
	'action' => 'PartyEmailController@index',
	'action_param' => array($party->id),
	'icon' => 'envelope-o',
	'label' => ($party->emails()->count() ? '<span class="badge pull-right">' . number_format($party->emails()->count()) . '</span>' : '') . Lang::choice('labels.party_email', 0),
);

$party_nav_items[] = array(
	'action' => 'PartyPhoneController@index',
	'action_param' => array($party->id),
	'icon' => 'phone',
	'label' => ($party->phones()->count() ? '<span class="badge pull-right">' . number_format($party->phones()->count()) . '</span>' : '') . Lang::choice('labels.party_phone', 0),
);

$party_nav_items[] = array(
	'action' => 'PartyAddressController@index',
	'action_param' => array($party->id),
	'icon' => 'map-marker',
	'label' => ($party->addresses()->count() ? '<span class="badge pull-right">' . number_format($party->addresses()->count()) . '</span>' : '') . Lang::choice('labels.party_address', 0),
);

?>
<ul class="nav {{ $nav_class or 'nav-pills nav-stacked' }}">
	@foreach($party_nav_items as $i => $nav)
		<li{{ $nav['action'] == $active_action ? ' class="active"' : '' }}>
			<a href="{{ action($nav['action'], $nav['action_param']) }}">
				@if($i === 0)<strong>@endif
				{{ HTML::icon($nav['icon'] . ' fa-fw') }}
				{{ $nav['label'] }}
				@if($i === 0)</strong>@endif
			</a>
		</li>
	@endforeach
</ul>
