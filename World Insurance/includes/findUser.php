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
    
    $findUserRecordID        = $_POST[ 'inputUserRecordID' ];
    $findUserEmail           = $_POST[ 'inputUserEmail' ];
	$findUserPass            = $_POST[ 'inputUserPass' ];
    $findUserAccountNumber   = $_POST[ 'inputUserAccountNumber' ];
    
    $preppedFindUserRecordID         = $db->real_escape_string($findUserRecordID);
    $preppedFindUserEmail            = $db->real_escape_string($findUserEmail);
    $preppedFindUserPass             = $db->real_escape_string($findUserPass);
    $preppedFindUserAccountNumber    = $db->real_escape_string($findUserAccountNumber);
    
    $SQLQuery = "SELECT * FROM CM_Users WHERE userRecordID = '$preppedFindUserRecordID';";
    
    if ( $result = $db->query($SQLQuery) === FALSE ) {
        
        error_log( "Error finding record: " . $db->error );
        return FALSE;
        
    }

    $db->close();
    
    return $result;

?>