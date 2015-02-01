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
        <title>Add Customers</title>

        <!-- Bootstrap CSS 3.3.2 -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" />

        <!-- Bootstrap Theme CSS 3.3.2 -->
        <link rel="stylesheet" href="../css/bootstrap-theme.min.css" />

        <!-- Sticky Footer CSS -->
        <link rel="stylesheet" href="../css/sticky-footer.css" />

        <!-- Dashboard CSS -->
        <link rel="stylesheet" href="../css/dashboard.css" />

        <!-- Form CSS -->
        <link rel="stylesheet" href="../css/form.css" />

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
        define('__ROOT__', dirname(dirname(__FILE__)));
        
        ?>
    </head>
    <body>
        <?php
        require_once(__ROOT__ . "/includes/header.php");
        
        if( $_SESSION['isAdmin'] == FALSE ) {
            
            die ("You do not have the required access to see this page!");
            
        }
        ?>

        <div class="container-fluid">
            <div class="row">
                <?php
                    require_once(__ROOT__ . "/includes/sidebar.php");
                ?>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
              <h1 class="page-header">Add Customers</h1>

                <form class="form-signin" id="addCustomerForm" onsubmit="return false;">
                    <h2 class="form-signin-heading" id="addCustomerFormTitle">New Customer Info</h2>
                    <label for="inputNewAccountNumber" class="sr-only">Account Number</label>
                    <input type="text" id="inputNewAccountNumber" name="inputNewAccountNumber" class="form-control form-first" placeholder="Account Number" autocomplete="off" autofocus />
                    <label for="inputNewFirstName" class="sr-only">First Name</label>
                    <input type="text" id="inputNewFirstName" name="inputNewFirstName" class="form-control form-middle" placeholder="First Name" autocomplete="off" />
                    <label for="inputNewLastName" class="sr-only">Last Name</label>
                    <input type="text" id="inputNewLastName" name="inputNewLastName" class="form-control form-middle" placeholder="Last Name" autocomplete="off" />
                    <label for="inputNewZip" class="sr-only">Zip Code</label>
                    <input type="text" id="inputNewZip" name="inputNewZip" class="form-control form-last" placeholder="Zip Code" autocomplete="off" />
                    <div style="text-align: right;">
                        <button id="addCustomerCancelButton" type="submit" class="btn btn-default">Cancel</button>
                        <button id="addCustomerAddButton" type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="text-muted">&copy; World Insurance 2014 Site Created &amp; Managed by techsym</p>
            </div>
        </footer>

        <!-- jQuery 1.11.2 -->
        <script src="../js/jquery.min.js"></script>

        <!-- jQuery JSON 2.5.1 -->
        <script src="../js/jquery.json.min.js"></script>

        <!-- Main JS 0.0.1 -->
        <script src="../js/main.js"></script>

        <!-- Bootstrap JS 3.3.2 -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Bootstrap Switch JS 3.3.1 -->
        <script src="../js/bootstrap-switch.min.js"></script>

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="../js/ie10-viewport-bug-workaround.js"></script>
    </body>
</html>