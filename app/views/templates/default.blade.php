@if(isset($heading) && strlen($heading) > 0)
	<h1>{{{ $heading }}}</h1>
@endif

@if(isset($body) && strlen($body) > 0)
	<div class="page-content">
		{{ $body }}
	</div>
@endif

