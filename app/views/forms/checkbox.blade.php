
@if(isset($options) && count($options) > 0)
	<div>
		@foreach($options as $k => $v)
			<div class="checkbox">
				<label>
					{{ Form::checkbox($name, $k, (isset($value) ? $k == $value || in_array($k, $value) : FALSE)) . $v }} 
				</label>
			</div>
		@endforeach
	</div>
@endif
