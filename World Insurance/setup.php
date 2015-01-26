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
        <title>World Insurance Setup Page</title>

        <!-- Bootstrap CSS 3.3.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" />

        <!-- Bootstrap Switch CSS 3.3.1 -->
        <link href="css/bootstrap-switch.min.css" rel="stylesheet" />

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
        
          require_once( __ROOT__ . "/includes/header.php" );
      
          $configExists = file_exists( __ROOT__ . "/config.php" );

          if ( $configExists ) {
          
            require_once(__ROOT__ . "/config.php");
            require_once(__ROOT__ . "/includes/database.php");
            
            $dbObject = new Database;
            $db = $dbObject->createDatabaseConnection();

          }
      
          // Initialize the variable that will hold all the HTML output
          $out = "<!-- Begin page content --><br /><br />
        <div class=\"container\">
            <div class=\"page-header\">
                <h1>Database Configuration</h1>
            </div>";
      
          if ( !$configExists ) {
          
            $out .= "<div class=\"container\">

                <form class=\"form-signin\" id=\"writeDatabaseConfigurationForm\">
                <h2 class=\"form-signin-heading\">Site Database Configuration Wizard</h2>
                <label for=\"inputDatabaseName\" class=\"sr-only\">Database Name</label>
                <input type=\"text\" id=\"inputDatabaseName\" name=\"inputDatabaseName\" class=\"form-control\" placeholder=\"Database Name\" required autofocus>
                <label for=\"inputDatabaseUserName\" class=\"sr-only\">Database User Name</label>
                <input type=\"text\" id=\"inputDatabaseUserName\" name=\"inputDatabaseUserName\" class=\"form-control\" placeholder=\"Database User Name\" required>
                <label for=\"inputDatabaseUserPass\" class=\"sr-only\">Database User Password</label>
                <input type=\"password\" id=\"inputDatabaseUserPass\" name=\"inputDatabaseUserPass\" class=\"form-control\" placeholder=\"Database User Password\">
                <label for=\"inputDatabaseHostname\" class=\"sr-only\">Database Hostname</label>
                <input type=\"text\" id=\"inputDatabaseHostname\" name=\"inputDatabaseHostname\" class=\"form-control\" placeholder=\"Database Hostname\" required>
                <button id=\"databaseSubmitButton\" class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Submit</button>
                </form>

            </div> <!-- /container -->";

          }
          else if( !$db->connect_errno ) {
            
            $out .= "<form class=\"form-signin\" id=\"loginRegisterForm\">
                                <h2 class=\"form-signin-heading\" id=\"loginRegisterFormTitle\">Please register</h2>
                                <label for=\"inputEmail\" class=\"sr-only\">Email</label>
                                <input type=\"email\" id=\"inputEmail\" class=\"form-control\" placeholder=\"Email\" required autofocus />
                                <label for=\"inputUserPass\" class=\"sr-only\">Password</label>
                                <input type=\"password\" id=\"inputUserPass\" class=\"form-control\" placeholder=\"Password\" required />
                                <label for=\"inputUserPassRepeat\" class=\"sr-only\">Repeat Password</label>
                                <input type=\"password\" id=\"inputUserPassRepeat\" class=\"form-control\" placeholder=\"Repeat Password\" required />
                            </form>";
          
          }
          else {
          
             $out .= "<p class=\"lead\">All configuration is completed. This file may be removed.</p></div>";
         
          }
          
          $out .= "
            <!-- jQuery 1.11.2 -->
            <script src=\"js/jquery.min.js\"></script>

            <!-- Main JS 0.0.1 -->
            <script src=\"js/main.js\"></script>

            <!-- Bootstrap JS 3.3.2 -->
            <script src=\"js/bootstrap.min.js\"></script>
            
            <!-- Bootstrap Switch JS 3.3.1 -->
            <script src=\"js/bootstrap-switch.min.js\"></script>";
          
          echo "$out";
      
       ?>
    </body>
</html>