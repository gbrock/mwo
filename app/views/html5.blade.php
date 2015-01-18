{{--

The default HTML5 file.

--}}<!DOCTYPE html>
@section('html_tag')
<html>
@show
<head>
	<meta charset="utf-8" />
	@section('head_meta')
	@show

	<title>{{ $page_title or 'Site Title' }}</title>
@if(isset($css) && is_array($css) && count($css))
	@foreach ($css as $stylesheet)
	
	<link rel="stylesheet" type="text/css" href="{{ 
			asset(
				(isset($style_base) ? trim($style_base, '/') . '/' : '')
				.
				trim($stylesheet, '/')
			)
		}}">
	@endforeach
@endif

</head>
@section('body_tag')
<body>
@show

@yield('body')
@if(isset($js) && is_array($js) && count($js))

	@foreach($js as $script)
<script src="{{ 
			asset(
				(isset($script_base) ? trim($script_base, '/') . '/' : '')
				.
				trim($script, '/')
			)
		}}"></script>
	@endforeach
@endif

</body>
</html>
