<?php

    // Starts a new session
    ob_start();
    session_start();

    // Determine site content root
    define('__ROOT__', dirname(dirname(__FILE__)));

    require_once( __ROOT__ . "/config.php" );
    require_once( __ROOT__ . "/includes/database.php" );
    require_once( __ROOT__ . "/includes/createHash.php" );

    // Setups up return array
    $ret = array(
        'returnObject' => "",
        'returnStatus' => "",
        'errorLog' => ""
    );

    $dbObject = new Database;
    $db = $dbObject->createDatabaseConnection();

    // Checks the database connection
    if ($db->connect_errno) {
    
        error_log( "Connection failed: " . $db->connect_error );
    
        $ret["returnStatus"] = "Fail";
        $ret["errorLog"] = "Connection failed: " . $db->connect_error;
    
        echo json_encode($ret);
    
    }

    $customerAccountNumber = $_SESSION[ 'accountNumber' ];

    $SQLQuery = "SELECT * FROM `cm`.`CM_Customers` WHERE `accountNumber` = '$customerAccountNumber';";

    $result = $db->query($SQLQuery);

    if ( $result === FALSE ) {
    
        error_log( "Error finding record: " . $db->error );
    
        $ret["returnStatus"] = "Fail";
        $ret["errorLog"] = "Error finding record: " . $db->error;
    
        echo json_encode($ret);
    
    }

    // Fetch returned row
    $row = $result->fetch_row();

    // Close the returned result
    $result->close();

    // Close the database connection
    $db->close();

    if( $row[2] == $preppedLoginUserEmail && validate_password($preppedLoginUserPass, $row[3])  ) {
    
        $_SESSION["userEmail"] = "$row[2]";
        $_SESSION["isAdmin"] = "$row[1]";
        $_SESSION["accountNumber"] = "$row[4]";
    
        $ret["returnStatus"] = "Success";
    
        echo json_encode($ret);
    
    }
    else {
    
        $ret["returnStatus"] = "Fail";
        $ret["errorLog"] = "Bad login";
    
        echo json_encode($ret);
    
    }

?>