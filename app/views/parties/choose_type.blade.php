<div class="form-group">
	<div class="btn-group">
		<button class="btn btn-default{{ $party_type == 'p' ? ' active' : ''}}" name="type" value="p">
			@choice('labels.person', 1)
		</button>
		<button class="btn btn-default{{ $party_type == 'o' ? ' active' : ''}}" name="type" value="o">
			@choice('labels.organization', 1)
		</button>
	</div>
</div>
