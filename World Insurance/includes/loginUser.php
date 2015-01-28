<?php

    // Starts a new session
    ob_start();
    session_start();

    // Determine site content root
    define('__ROOT__', dirname(dirname(__FILE__)));
    
    require_once( __ROOT__ . "/config.php" );
    require_once( __ROOT__ . "/includes/database.php" );
    require_once( __ROOT__ . "/includes/createHash.php" );
    
    $dbObject = new Database;
    $db = $dbObject->createDatabaseConnection();
    
    // Checks the database connection
    if ($db->connect_errno) {
        
        error_log( "Connection failed: " . $db->connect_error );
        return FALSE;
        
    }
    
    $loginUserEmail           = $_GET[ 'inputLoginEmail' ];
	$loginUserPass            = $_GET[ 'inputLoginUserPass' ];
    
    $preppedLoginUserEmail  = $db->real_escape_string($loginUserEmail);
    $preppedLoginUserPass   = $db->real_escape_string($loginUserPass);
    
    $SQLQuery = "SELECT * FROM `cm`.`CM_Users` WHERE userEmail = $preppedLoginUserEmail;";
    
    if ( $result = $db->query($SQLQuery) === FALSE ) {
        
        error_log( "Error finding record: " . $db->error );
        return "Ended badly";
        
    }
    
    // Fetch returned row
    $row = $result->fetch_row();
    
    if( $row[2] == $preppedLoginUserEmail && validate_password($preppedLoginUserPass, $row[3])  ) {
    
        $_SESSION["userEmail"] = "$row[2]";
		$_SESSION["isAdmin"] = "$row[1]";
		$_SESSION["accountNumber"] = "$row[4]";
        
        return TRUE;
    
    }
    
    // Close the returned result
    $result->close();

    // Close the database connection
    $db->close();
    
    return FALSE;

?>