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

    $SQLQuery = "SELECT * FROM `cm`.`CM_Customers` WHERE `accountNumber` LIKE '%$customerAccountNumber%';";

    $result = $db->query($SQLQuery);

    while($row = $result->fetch_row()) {
            
        $accountNumber  = $row["accountNumber"];
        $firstName      = $row["customerFirstName"];
        $lastName       = $row["customerLastName"];
        $zip            = $row["customerZip"];
            
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
    
    }

?>