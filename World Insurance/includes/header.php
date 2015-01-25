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
                                <a type=\"button\" class=\"btn btn-primary navbar-btn\" data-toggle=\"modal\" data-target=\"#registerModal\">Register</a>";
                            
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