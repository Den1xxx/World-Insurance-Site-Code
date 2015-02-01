<?php

    // Starts a new session
    ob_start();
    session_start();

    // Determine site content root
    define('__ROOT__', dirname(dirname(__FILE__)));

    require_once( __ROOT__ . "/config.php" );
    require_once( __ROOT__ . "/includes/database.php" );
    require_once( __ROOT__ . "/includes/createHash.php" );
    
    // Sets up return array
    $ret = array(
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

    $customerAccountNumber  = $_GET[ 'inputSearchAccountNumber' ];
    $customerFirstName      = $_GET[ 'inputSearchFirstName' ];
    
    if($customerAccountNumber == "" && $customerFirstName == "") {
    
        die();
    
    }
    else if($customerAccountNumber == "") {
    
        $customerAccountNumber = "999999999";
    
    }
    else if($customerFirstName == "") {
    
        $customerFirstName = "NULL";
    
    }

    $SQLQuery = "SELECT * FROM `cm`.`CM_Customers` WHERE (`accountNumber` LIKE '%$customerAccountNumber%' OR `customerFirstName` LIKE '%$customerFirstName%') ORDER BY `accountNumber` DESC;";
    
    $result = $db->query($SQLQuery);

    while($row = $result->fetch_row()) {
            
        $accountNumber  = $row[1];
        $firstName      = $row[2];
        $lastName       = $row[3];
        $zip            = $row[4];
            
        echo
            "<tr>" . 
            "   <td>$accountNumber</td>" .
            "   <td>$firstName</td>" .
            "   <td>$lastName</td>" .
            "   <td>$zip</td>" .
            "</tr>";
            
    }

    // Close the returned result
    $result->close();

    // Close the database connection
    $db->close();

?>