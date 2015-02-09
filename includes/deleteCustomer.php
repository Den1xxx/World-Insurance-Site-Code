<?php

	// Determine site content root
	$webroot = dirname(dirname(__FILE__));

	require_once( $webroot . "/config.php" );
	require_once( $webroot . "/includes/database.php" );

	// Sets up return array
	$ret = array(
		'returnObject' => "",
		'returnStatus' => "",
		'errorLog' => ""
	);

	// Creates a new Database object, and then establishes a connection to the
	// Database
	$dbObject = new Database;
	$db = $dbObject->createDatabaseConnection();

	// Checks the database connection
	if ($db->connect_errno) {

		// Logs the connection error
		error_log( "Connection failed: " . $db->connect_error );

		// Add the error to the return array
		$ret["returnStatus"] = "Connection Failed";
		$ret["errorLog"] = "Connection failed: " . $db->connect_error;

		// Return the array as a JSON object
		echo json_encode($ret);

		// Break out of the PHP script
		die();

	}

	// Save the inputs to variables
	$customerAccountNumber = $_GET[ 'inputAccountNumber' ];

	// Sanitize all the input
	$customerAccountNumber = $db->real_escape_string($customerAccountNumber);

	// Build the SQL query that will be used to delete the customer in the
	// database
	$SQLQuery = "DELETE FROM `" . DB_NAME . "`.`CM_Customers` " .
		"WHERE `" . DB_NAME . "`.`CM_Customers`.`accountNumber` " .
			"= '$customerAccountNumber';";

	// Execute the query on the database object
	$db->query($SQLQuery);

	// Checks to see if the customer was deleted
	if ($db->affected_rows == 0) {

		// Customer not deleted, set the return status to "Customer Not Deleted"
		$ret['returnStatus'] = "Customer Not Deleted";

		// Return the array as a JSON object
		echo json_encode($ret);

		// Break out of the PHP script
		die();

	}

	// Customer was deleted successfully
	$ret['returnStatus'] = "Customer Deleted";

	// Return the array as a JSON object
	echo json_encode($ret);

	// Close the database connection
	$db->close();

?>