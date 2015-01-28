{{ Form::open(array(
	'action' => array('UserGroupController@destroy', $group->id),
	'method' => 'DELETE',
)) }}
<h3>
	{{ HTML::icon('user') }}
	@lang('security.permissions_for', array('name' => $group->name))
	<div class="btn-group">
		<a class="btn btn-link" href="{{ action('UserGroupController@edit', array($group->id)) }}">
			{{ HTML::icon('pencil') }}
		</a>
		<button type="submit" class="btn btn-link">
			{{ HTML::icon('trash') }}
		</button>
		<a class="btn btn-link" href="{{ action('UserGroupController@newPermission', array($group->id)) }}">
			{{ HTML::icon('plus-circle') }}
		</a>
	</div>
</h3>
{{ Form::close() }}

{{ Form::open(array(
	'action' => array('UserGroupController@updatePermissions', $group->id),
	// 'method' => 'PUT',
)) }}
<div class="panel panel-default">
	
@if(count($permissions))
	<div class="list-group">
		@foreach($permissions as $name)
			<label class="list-group-item">
				<div class="pull-right">
					<input type="checkbox" name="allow[{{{ $name }}}]" value="1" {{ 
					(
						isset($group->permissions[$name]) && $group->permissions[$name]
						 ? 'checked'
						 : ''
					) }}>
				</div>
				{{{ $name }}}
			</label>
		@endforeach
	</div>
@else
	<div class="panel-body">
		<div class="alert alert-info">
			@lang('security.empty_permissions')
		</div>
	</div>
@endif

	<div class="panel-footer">
		@include('forms.submit')
	</div>
</div>

{{ Form::close() }}
