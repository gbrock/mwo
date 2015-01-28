<div class="panel panel-default">
	<div class="panel-body">
		<dl class="dl-horizontal">
			@include('users.info')
		</dl>
	</div>
	<div class="panel-footer clearfix">
		<div class="pull-right">
			<a href="{{ action('UserController@edit', array($user->party->id, $user->id)) }}" class="btn btn-primary">
				@lang('labels.edit_item', array(
					'item' => Lang::choice('labels.account', 1),
				))
			</a>
		</div>
	</div>
</div>
