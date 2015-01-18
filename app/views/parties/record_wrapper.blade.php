@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">
			<img src="http://placehold.it/800x800" class="img-responsive img-rounded">
			<br>
			@include('parties.show_nav')
			<br>
			<div class="well well-sm small text-muted">
				@lang('parties.id') <strong class="pull-right">#{{ $party->id }}</strong>
				<br>
				@if($party->created_at->timestamp !== $party->updated_at->timestamp)
					@lang('labels.updated_at') <strong class="pull-right">
						<abbr title="{{ $party->updated_at->toDayDateTimeString()}}">
							{{ $party->updated_at->diffForHumans() }}
						</abbr>
					</strong>
					<br>
				@endif
				@lang('labels.created_at') <strong class="pull-right">
					<abbr title="{{ $party->created_at->toDayDateTimeString()}}">
						{{ $party->created_at->diffForHumans() }}
					</abbr>
				</strong>
			</div>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-8 col-lg-9">
			{{ Form::open(array(
				'action' => array('PartyController@destroy', $party->id),
				'method' => 'DELETE',
			)) }}
			<h3>
				{{ HTML::icon($party->icon) }}
				{{{ $party->name }}}
				<div class="btn-group btn-group-xs">
					<a href="{{ action('PartyController@edit', array($party->id)) }}" class="btn btn-link">
						<i class="fa fa-edit">&nbsp;</i>
						@lang('labels.edit')
					</a>
					<button type="submit" class="btn btn-link">
						<i class="fa fa-trash">&nbsp;</i>
						@lang('labels.destroy')
					</button>
				</div>
			</h3>
			{{ Form::close() }}
			<div class="panel panel-default">
				@if(isset($form_action))	
					{{ Form::open(array(
						'action' => $form_action,
					)) }}
				@endif
				<div class="panel-body">
					{{-- $inner --}}
				</div>
				@if(isset($form_action))
					<div class="panel-footer">
						<div class="clearfix">
							<div class="pull-right">
								<div class="btn-group">
									<button type="submit" class="btn btn-success">
										{{ $form_submit or 'Submit'}}
									</button>
								</div>
							</div>
						</div>
					</div>
					{{ Form::close() }}
				@endif
			</div>
		</div>
	</div>
@stop
