<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ Lang::get('site.name') }}</title>

	<link href="{{ url('css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
    @section('body')
        <div class="page-wrap">
    	    @include('includes.navbar', array(
    	        'brand' => Lang::get('site.name'),
    	    ))
    	    @yield('content')
        </div>
        @section('footer')
        <footer class="site-footer">
            @include('includes.navbar', array(
                'class' => 'navbar-inverse',
                'content' => '<span class="navbar-left"><span class="navbar-text">MWO Blog created by gBrock</span></span>',
            ))
        </footer>
        @show

    @show

	<!-- Scripts -->
	<script src="{{ url('js/plugins.js') }}"></script>
</body>
</html>