{{ Form::open(array(
	'action' => array('UserGroupController@storePermission', $group->id)
)) }}
@if(isset($group) && count($group->permissions))
	@foreach($group->permissions as $p)

	@endforeach
@endif
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">
			@lang('labels.create_item', array('item' => Lang::choice('labels.permission', 1)))
		</h4>
	</div>
	<div class="panel-body">
		@include('permissions.form')
	</div>
	<div class="panel-footer">
		@include('forms.submit', array(
			'label' => Lang::get('labels.create_item', array('item' => Lang::choice('labels.permission', 1)))
		))
	</div>
</div>
{{ Form::close() }}
