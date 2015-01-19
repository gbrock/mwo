<?php

$active_action = (isset($active_action) ? $active_action : Route::currentRouteAction());

$party_nav_items = array();

$party_nav_items[] = array(
	'action' => 'PartyController@show',
	'action_param' => array($party->id),
	'icon' => $party->icon,
	'label' => $party->name,
);

$party_nav_items[] = array(
	'action' => 'PartyLinkController@index',
	'action_param' => array($party->id),
	'icon' => 'link',
	'label' => Lang::choice('labels.party_link', $party->links()->count()),
);

?>
<ul class="nav nav-pills nav-stacked">
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
