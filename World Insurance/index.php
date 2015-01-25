<?php
    // Starts a new session
    ob_start();
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>World Insurance Home Page</title>

        <!-- Bootstrap CSS 3.3.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" />

        <!-- Bootstrap Theme CSS 3.3.2 -->
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" />

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!-- HTML5 Shiv 3.7.2 -->
        <!-- Respond 1.4.2 -->
        <!--[if lt IE 9]>
            <script src="js/html5shiv.min.js"></script>
            <script src="js/respond.min.js"></script>
        <![endif]-->

        <?php
      
            // Determine site content root
            define('__ROOT__', dirname(__FILE__));
      
        ?>
    </head>
    <body>
        <?php
                require_once(__ROOT__ . "/includes/header.php");
        ?>

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div class="container">
                <h1>World Insurance</h1>
                <p>Having your best interests in heart, we strive to make sure you are getting the best possible policy!</p>
                <p>
                    <a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a>
                </p>
            </div>
        </div>

        <!-- Three columns of info -->
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2>Heading</h2>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p>
                        <a class="btn btn-default" href="#" role="button">View details &raquo;</a>
                    </p>
                </div>
                <div class="col-md-4">
                    <h2>Heading</h2>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p>
                        <a class="btn btn-default" href="#" role="button">View details &raquo;</a>
                    </p>
                </div>
                <div class="col-md-4">
                    <h2>Heading</h2>
                    <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                    <p>
                        <a class="btn btn-default" href="#" role="button">View details &raquo;</a>
                    </p>
                </div>
            </div>

            <!-- Login Modal -->
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="loginModalLabel">Login to access your policies</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-signin" id="loginForm">
                                <h2 class="form-signin-heading" id="loginFormTitle">Please login</h2>
                                <label for="inputLoginEmail" class="sr-only">Email</label>
                                <input type="email" id="inputLoginEmail" class="form-control" placeholder="Email" required autofocus />
                                <label for="inputLoginUserPass" class="sr-only">Password</label>
                                <input type="password" id="inputLoginUserPass" class="form-control" placeholder="Password" required />
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button id="loginButton" type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Register Modal -->
            <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="registerModalLabel">Register</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-signin" id="registerForm">
                                <h2 class="form-signin-heading" id="registerFormTitle">Please register</h2>
                                <label for="inputRegisterEmail" class="sr-only">Email</label>
                                <input type="email" id="inputRegisterEmail" class="form-control" placeholder="Email" required autofocus />
                                <label for="inputRegisterUserPass" class="sr-only">Password</label>
                                <input type="password" id="inputRegisterUserPass" class="form-control" placeholder="Password" required />
                                <label for="inputRegisterUserPassRepeat" class="sr-only">Repeat Password</label>
                                <input type="password" id="inputRegisterUserPassRepeat" class="form-control" placeholder="Repeat Password" required />
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button id="registerButton" type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /container -->

        <footer class="footer">
            <div class="container">
                <p class="text-muted">&copy; World Insurance 2014 Site Created &amp; Managed by techsym</p>
            </div>
        </footer>

        <!-- jQuery 1.11.2 -->
        <script src="js/jquery.min.js"></script>

        <!-- Main JS 0.0.1 -->
        <script src="js/main.js"></script>

        <!-- Bootstrap JS 3.3.2 -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Bootstrap Switch JS 3.3.1 -->
        <script src="js/bootstrap-switch.min.js"></script>

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="js/ie10-viewport-bug-workaround.js"></script>
    </body>
</html>