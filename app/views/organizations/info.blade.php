<dt>
	@lang('organizations.founded')
</dt>
<dd>
	{{ $party->organization->founded ? $party->organization->founded->toFormattedDateString() : '&mdash;' }}
</dd>
