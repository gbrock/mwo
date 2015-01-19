@extends('parties.record_wrapper')

@section('inner')
	<div class="panel panel-default">
		<div class="panel-body">
			<dl class="dl-horizontal">
				@if($party->isPerson())
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
				@endif

				@if($party->isOrganization())
					<dt>
						@lang('organizations.founded')
					</dt>
					<dd>
						{{ $party->organization->founded ? $party->organization->founded->toFormattedDateString() : '&mdash;' }}
					</dd>
				@endif
			</dl>
		</div>
	</div>
@stop
