<?php
$Route = Route::current();
$action = $Route->getAction();
$namespace = '\\' . $action['namespace'] . '\\';
$currentController = str_replace($action['namespace'] . '\\', "", $action['controller']);
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
        foreach ($css as $src) {
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
            site = <?php echo json_encode($jsParameters); ?>
        </script>
    </head>
    <body id="<?php echo $id_page; ?>">

        <div class="container">
            <nav id="menu" class="navbar navbar-sea">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo action(config('app.backend_namespace') . 'DashboardController@index'); ?>"><?php echo config('app.name'); ?></a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <?php echo $menu; ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo trans('main.account'); ?><span class="caret"></span></a>
                            <?php
                            $parameters = array(
                                'action' => 'edit',
                                'indexes' => array('users.id' => session('id')),
                                'identifier' => 'users',
                            );
                            $uri = action(config('app.backend_namespace') . 'UsersController@index');
                            $queryString = http_build_query($parameters);
                            $urlEdit = url($uri . "?" . $queryString);
                            ?>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo $urlEdit; ?>"><?php echo trans('main.edit'); ?></a></li>
                                <li><a href="<?php echo action(config('app.backend_namespace') . 'AuthController@logout'); ?>"><?php echo trans('main.logout'); ?></a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </nav>
        </div>

        <div id="content">
            @yield('content')
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
                    <div class="modal-body modal-body-scroller">
                        <?php echo ucfirst(trans('main.modal.body')); ?>
                    </div>
                    <div class="modal-footer">
                        <div class="xrow">
                            <div class="col-6">
                                <button type="button" class="btn btn-action btn-white btn-block" value=""><?php echo trans('main.no'); ?></button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-action btn-blue btn-block" value="1"><?php echo trans('main.yes'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- javascript files -->
        <?php
        foreach ($js as $src) {
            ?>
            <script type="text/javascript" src="<?php echo url($src); ?>"></script>
            <?php
        }
        ?>
        @stack('scripts')
    </body>
</html>
