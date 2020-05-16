<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	@yield('meta')
	<link rel="icon" href="<?php echo url('images/logo.png'); ?>">
	<title>@yield('page_title')</title>
	<link rel="alternate" type="application/rss+xml" title="IdCoderBlog Feed" href="<?php echo action(config('app.frontend_namespace') . 'BlogController@rss'); ?>" />
	<!-- Bootstrap core CSS -->
	<link href="<?php echo url('css/bootstrap.min.css'); ?>" rel="stylesheet">
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="<?php echo url('css/ie10-viewport-bug-workaround.css'); ?>" rel="stylesheet">
	<link href="<?php echo url('css/themes/standard/frontend.css'); ?>" rel="stylesheet">
	<link href="<?php echo url('css/themes/standard/responsive.css'); ?>" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	@include('frontend.themes.standard.analyticstracking')
</head>
<body>
	<div id="page-header">
		<div id="logo"><a href="<?php echo url(''); ?>"><img src="<?php echo url('images/logo.png'); ?>" /></a></div>
	</div>
	<div id="page-content" class="container">
	@yield('content')
	</div>
	<div id="page-footer" class="container">
	  <div class="row">
	    <div class="col-sm-6">
	    	<div class="copyright">&copy; 2017 Joko Wandiro</div>
	    </div>
	  </div>
	</div>
	<!-- javascript files -->
	<script type="text/javascript" src="<?php echo url('js/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo url('js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo url('js/ie10-viewport-bug-workaround.js'); ?>"></script>
	<script>
	window.site= <?php echo json_encode($jsParameters); ?>;
	</script>
	@stack('scripts')
</body>
</html>
