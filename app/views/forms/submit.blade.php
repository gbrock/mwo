<div class="clearfix">
	<div class="btn-group {{ $btn_group_class or 'btn-group-lg pull-right' }}">
		{{ $btns or '' }}
		<button type="submit" name="save" class="btn {{ $btn_class or 'btn-success' }}">
			{{ $label or '<span class="fa fa-save">&nbsp;</span>' . Lang::get('labels.save') }}
		</button>
	</div>
</div>
