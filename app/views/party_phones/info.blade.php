<dt>
	@lang('party_phones.number')
</dt>
<dd>
	{{{ $phone->number }}}
</dd>
<dt>
	@lang('party_phones.extension')
</dt>
<dd>
	{{{ $phone->extension or '&mdash;' }}}
</dd>
<dt>
	@lang('party_phones.type')
</dt>
<dd>
	{{{ $phone->type or '&mdash;' }}}
</dd>
