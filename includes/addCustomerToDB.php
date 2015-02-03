<?php

    // Determine site content root
    define('__ROOT__', dirname(dirname(__FILE__)));

    require_once( __ROOT__ . "/config.php" );
    require_once( __ROOT__ . "/includes/database.php" );

    // Sets up return array
    $ret = array(
        'returnStatus' => "",
        'errorLog' => ""
    );

    $dbObject = new Database;
    $db = $dbObject->createDatabaseConnection();

    // Checks the database connection
    if ($db->connect_errno) {
    
        $ret["returnStatus"] = "Fail";
        $ret["errorLog"] = "Connection failed: " . $db->connect_error;
    
        echo json_encode($ret);
    
    }
    else {
    
        $newCustomerAccountNumber   = $_POST[ 'inputNewAccountNumber' ];
        $newCustomerFirstName       = $_POST[ 'inputNewFirstName' ];
        $newCustomerLastName        = $_POST[ 'inputNewLastName' ];
        $newCustomerZip             = $_POST[ 'inputNewZip' ];
        $newCustomerPolicyNumbers   = "";
        $newCustomerPolicyPDFs      = "";

        $preppedNewCustomerAccountNumber    = $db->real_escape_string($newCustomerAccountNumber);
        $preppedNewCustomerFirstName        = $db->real_escape_string($newCustomerFirstName);
        $preppedNewCustomerLastName         = $db->real_escape_string($newCustomerLastName);
        $preppedNewCustomerZip              = $db->real_escape_string($newCustomerZip);
        $preppedNewCustomerPolicyNumbers    = $db->real_escape_string($newCustomerPolicyNumbers);
        $preppedNewCustomerPolicyPDFs       = $db->real_escape_string($newCustomerPolicyPDFs);
        
        $SQLQuery = "SELECT * FROM `cm`.`CM_Customers` WHERE accountNumber = '$preppedNewCustomerAccountNumber';";
        
        $result = $db->query($SQLQuery);
        $existingAccountNumber = $result->num_rows;
        
        // Close the returned result
        $result->close();
        
        if($existingAccountNumber > 0) {
            
            $ret["returnStatus"] = "Duplicate Account Number";
            $ret["errorLog"] = "Error creating record: " . $db->error;
            
            echo json_encode($ret);
            
        }
        else {
            
            $SQLQuery = "INSERT INTO `cm`.`CM_Customers` (`customerRecordID`, `accountNumber`, `customerFirstName`, `customerLastName`, `customerZip`, `customerPolicyNumbers`, `customerPolicyPDFs`) VALUES (NULL, '$preppedNewCustomerAccountNumber', '$preppedNewCustomerFirstName', '$preppedNewCustomerLastName', '$preppedNewCustomerZip', '$preppedNewCustomerPolicyNumbers', '$preppedNewCustomerPolicyPDFs');";

            if ( $db->query($SQLQuery) === FALSE ) {
                
                $ret["returnStatus"] = "Fail";
                $ret["errorLog"] = "Error creating record: " . $db->error;
                
                echo json_encode($ret);
                
            }
            else {
                
                $ret["returnStatus"] = "Success";

                echo json_encode($ret);
                
            }
            
        }
    
    }

    // Close the database connection
    $db->close();

?>