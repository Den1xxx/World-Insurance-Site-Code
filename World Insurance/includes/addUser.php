<?php

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
    
    $newUserEmail           = $_POST[ 'inputUserEmail' ];
	$newUserPass            = $_POST[ 'inputUserPass' ];
    $newUserAccountNumber   = $_POST[ 'inputUserAccountNumber' ];
	$newIsAdmin             = $_POST[ 'inputIsAdmin' ];
    $hashUserPass           = create_hash("$newUserPass");
    
    $preppedNewUserEmail            = $db->real_escape_string($newUserEmail);
    $preppedNewUserPass             = $db->real_escape_string($hashUserPass);
    $preppedNewUserAccountNumber    = $db->real_escape_string($newUserAccountNumber);
    $preppedNewIsAdmin              = $db->real_escape_string($newIsAdmin);
    
    $SQLQuery = "INSERT INTO `cm`.`CM_Users` (`userRecordID`, `isAdmin`, `userEmail`, `userPassword`, `accountNumber`) VALUES (NULL, '$preppedNewIsAdmin', '$preppedNewUserEmail', '$preppedNewUserPass', '$preppedNewUserAccountNumber');";
    
    if ( $db->query($SQLQuery) === FALSE ) {
        
        error_log( "Error creating table: " . $db->error );
        return FALSE;
        
    }

    $db->close();
    
    return TRUE;

?>