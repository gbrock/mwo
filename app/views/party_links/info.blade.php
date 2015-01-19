<dt>
	@lang('party_links.url')
</dt>
<dd>
	{{{ $link->url }}}
	<a class="btn btn-sm btn-link pull-right" href="{{{ $link->url }}}">
		{{ Lang::get('labels.visit_external') }}
		{{ HTML::icon('external-link') }}
	</a>
</dd>
