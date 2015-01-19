<dt>
	@lang('people.gender')
</dt>
<dd>
	{{{  $party->person->gender or '&mdash;'  }}}
</dd>
<dt>
	@lang('people.birth')
</dt>
<dd>
	{{ $party->person->birth ? $party->person->birth->toFormattedDateString() : '&mdash;' }}
</dd>
