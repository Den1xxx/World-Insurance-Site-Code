<?php

    // Determine site content root
    define('__ROOT__', dirname(__FILE__));
    
   $currentPage = $_SERVER['REQUEST_URI'];
   $out = "";
   
   $out .= "<nav class=\"navbar navbar-default navbar-fixed-top\">
                <div class=\"container-fluid\">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class=\"navbar-header\">
                        <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\"
                                data-target=\"#bs-example-navbar-collapse-1\">
                            <span class=\"sr-only\">Toggle navigation</span>
                            <span class=\"icon-bar\"></span>
                            <span class=\"icon-bar\"></span>
                            <span class=\"icon-bar\"></span>
                        </button>
                        <a class=\"navbar-brand\" href=\"index.php\">World Insurance</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class=\"collapse navbar-collapse\" id=\"mainNav\">
                        <ul class=\"nav navbar-nav\">
                            <li class=\"dropdown\">
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\"
                                   aria-expanded=\"false\">
                                    Policies <span class=\"caret\"></span>
                                </a>
                                <ul class=\"dropdown-menu\" role=\"menu\">
                                    <li>
                                        <a href=\"#\">Auto</a>
                                    </li>
                                    <li>
                                        <a href=\"#\">Home</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href=\"about.php\">About</a>
                            </li>
                        </ul>
                        <ul class=\"nav navbar-nav navbar-right\">";
                        
    // Only displays the admin link in the navbar if an admin is logged in
    if( $_SESSION['isAdmin'] == TRUE ) {
                        
        $out .= "<li>
            <a href=\"admin.php\">Admin</a>
        </li>";
                        
    }
                            
    if( isset($_SESSION['userID']) ) {
                            
        $out .= "<li class=\"dropdown\">
        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\"
            aria-expanded=\"false\">
            Account <span class=\"caret\"></span>
        </a>
        <ul class=\"dropdown-menu\" role=\"menu\">
            <li>
                <a href=\"#\">Profile</a>
            </li>
            <li>
                <a href=\"#\">Policies</a>
            </li>
            <li class=\"divider\"></li>
            <li>
                <a href=\"#\">Logout</a>
            </li>
        </ul>
    </li>";
                            
    }
    else if( $currentPage == "/worldins/setup.php" ) {
                            
        // Do nothing
                            
    }
    else {
                            
        $out .= "<a type=\"button\" class=\"btn btn-primary navbar-btn\" data-toggle=\"modal\" data-target=\"#loginModal\">Login</a>
        <a type=\"button\" class=\"btn btn-primary navbar-btn\" data-toggle=\"modal\" data-target=\"#registerModal\">Register</a>
        <!-- Login Modal -->
            <div class=\"modal fade\" id=\"loginModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"loginModalLabel\"
                 aria-hidden=\"true\">
                <div class=\"modal-dialog\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">&times;</span>
                            </button>
                            <h4 class=\"modal-title\" id=\"loginModalLabel\">Login to access your policies</h4>
                        </div>
                        <div class=\"modal-body\">
                            <form class=\"form-signin\" id=\"loginForm\">
                                <h2 class=\"form-signin-heading\" id=\"loginFormTitle\">Please login</h2>
                                <label for=\"inputLoginEmail\" class=\"sr-only\">Email</label>
                                <input type=\"email\" id=\"inputLoginEmail\" name=\"inputLoginEmail\" class=\"form-control\" placeholder=\"Email\" required autofocus />
                                <label for=\"inputLoginUserPass\" class=\"sr-only\">Password</label>
                                <input type=\"password\" id=\"inputLoginUserPass\" name=\"inputLoginUserPass\" class=\"form-control\" placeholder=\"Password\" required />
                            </form>
                        </div>
                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Cancel</button>
                            <button id=\"loginButton\" type=\"submit\" class=\"btn btn-primary\">Login</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Register Modal -->
            <div class=\"modal fade\" id=\"registerModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"registerModalLabel\" aria-hidden=\"true\">
                <div class=\"modal-dialog\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">&times;</span>
                            </button>
                            <h4 class=\"modal-title\" id=\"registerModalLabel\">Register</h4>
                        </div>
                        <div class=\"modal-body\">
                            <form class=\"form-signin\" id=\"registerForm\">
                                <h2 class=\"form-signin-heading\" id=\"registerFormTitle\">Please register</h2>
                                <label for=\"inputRegisterEmail\" class=\"sr-only\">Email</label>
                                <input type=\"email\" id=\"inputRegisterEmail\" class=\"form-control\" placeholder=\"Email\" required autofocus />
                                <label for=\"inputRegisterUserPass\" class=\"sr-only\">Password</label>
                                <input type=\"password\" id=\"inputRegisterUserPass\" class=\"form-control\" placeholder=\"Password\" required />
                                <label for=\"inputRegisterUserPassRepeat\" class=\"sr-only\">Repeat Password</label>
                                <input type=\"password\" id=\"inputRegisterUserPassRepeat\" class=\"form-control\" placeholder=\"Repeat Password\" required />
                            </form>
                        </div>
                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Cancel</button>
                            <button id=\"registerButton\" type=\"submit\" class=\"btn btn-primary\">Register</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /container -->";
                            
    }
                            
    $out .= "
</ul>
</div>
<!-- /.navbar-collapse -->
</div>
<!-- /.container-fluid -->
</nav>";
            
    echo "$out";
?>