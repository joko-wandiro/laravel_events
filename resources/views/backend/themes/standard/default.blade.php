<?php
$Route= Route::current();
$action= $Route->getAction();
$namespace= '\\' . $action['namespace'].'\\';
$currentController= str_replace($action['namespace'].'\\', "", $action['controller']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Joko Wandiro">
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
    <link rel="icon" href="<?php echo url('images/logo.png'); ?>">
    <title><?php echo config('app.name'); ?></title>
    <!-- CSS files -->
    <?php
    foreach( $css as $src ){
		?>
	<link href="<?php echo url($src); ?>" rel="stylesheet">
		<?php
	}
    ?>
    @stack('styles')
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
    site= <?php echo json_encode($jsParameters); ?>
    </script>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 sidebar">
			<div id="navbar-header-sidebar" class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Notee</a>
			</div>
			<div id="sidebar" aria-expanded="false" class="collapse" style="height: 0px;">
				<?php echo $menu; ?>
			</div>
        </div>
        <div class="col-sm-9 col-sm-offset-3">
			<ol class="breadcrumb">
				<li><a href="<?php echo action(config('app.backend_namespace') . 'DashboardController@index'); ?>">Home</a></li>
				<?php
				$breadcrumbLength= count($breadcrumb);
				$ct= 1;
				foreach( $breadcrumb as $menu ){
					if( $breadcrumbLength == $ct ){
					?>
					<li class="active"><?php echo $menu['name']; ?></li>
					<?php
					}else{
					?>
					<li><a href="<?php echo $menu['url']; ?>"><?php echo $menu['name']; ?></a></li>
					<?php
					}
					$ct++;
				}
				?>
			</ol>
			<div id="content">
			@yield('content')
			</div>
        </div>
      </div>
    </div>
    <!-- Modal - Loading -->
    <div id="modal-loading" class="modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body modal-body-scroller text-center">
                    <?php echo ucfirst(trans('main.modal.body')); ?>
                </div>
            </div>
        </div>
    </div>
                
    <!-- Modal - Confirmation Box -->
    <div id="confirmation-box" class="modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align:center; color:#1ca8dd; text-transform:uppercase;"><?php echo ucfirst(trans('main.modal.title')); ?>...</h4>
                </div>
                <div class="modal-body modal-body-scroller">
                    <?php echo ucfirst(trans('main.modal.body')); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-action" value="1">OK</button>
                    <button type="button" class="btn btn-default btn-action" value="">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- javascript files -->
    <?php
    foreach( $js as $src ){
		?>
	<script type="text/javascript" src="<?php echo url($src); ?>"></script>
		<?php
	}
    ?>
    @stack('scripts')
  </body>
</html>
