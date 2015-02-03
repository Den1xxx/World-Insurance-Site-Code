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
    
    $findUserRecordID        = $_GET[ 'inputUserRecordID' ];
    $findUserEmail           = $_GET[ 'inputUserEmail' ];
	$findUserPass            = $_GET[ 'inputUserPass' ];
    $findUserAccountNumber   = $_GET[ 'inputUserAccountNumber' ];
    
    $preppedFindUserRecordID         = $db->real_escape_string($findUserRecordID);
    $preppedFindUserEmail            = $db->real_escape_string($findUserEmail);
    $preppedFindUserPass             = $db->real_escape_string($findUserPass);
    $preppedFindUserAccountNumber    = $db->real_escape_string($findUserAccountNumber);
    
    $SQLQuery = "SELECT * FROM `cm`.`CM_Users` WHERE userRecordID = $preppedFindUserRecordID;";
    
    if ( $result = $db->query($SQLQuery) === FALSE ) {
        
        error_log( "Error finding record: " . $db->error );
        return "Ended badly";
        
    }

    $db->close();
    
    //return $result;
    return "ended well";

?>