<?php

	// Determine site content root
	$webroot = dirname(dirname(__FILE__));

	require_once( $webroot . "/config.php" );
	require_once( $webroot . "/includes/database.php" );

	// Sets up return array
	$ret = array(
		'returnObject' => "",
		'returnStatus' => "",
		'fileUploaded' => false,
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
	$customerAccountNumber = $_POST[ 'inputGenModalAccountNumber' ];
	$customerFirstName     = $_POST[ 'inputGenModalFirstName' ];
	$customerLastName      = $_POST[ 'inputGenModalLastName' ];
	$customerZip           = $_POST[ 'inputGenModalZip' ];

	// Sanitize all the input
	$customerAccountNumber = $db->real_escape_string($customerAccountNumber);
	$customerFirstName     = $db->real_escape_string($customerFirstName);
	$customerLastName      = $db->real_escape_string($customerLastName);
	$customerZip           = $db->real_escape_string($customerZip);

	// Build the SQL query that will be used to update the customer in the
	// database
	$SQLQuery = "UPDATE `" . DB_NAME . "`.`" . TBL_CUSTOMER . "` " .
		"SET `accountNumber` = '$customerAccountNumber', " .
		"`customerFirstName` = '$customerFirstName', " .
		"`customerLastName` = '$customerLastName', " .
		"`customerZip` = '$customerZip' " .
		"WHERE `" . DB_NAME . "`.`" . TBL_CUSTOMER . "`.`accountNumber` " .
			"= '$customerAccountNumber';";

	// Execute the query on the database object
	$db->query($SQLQuery);

	// Checks to see if the customer was updated
	if ($db->affected_rows == 0) {

		// No customers updated, set the return status to "Customer Not Updated"
		$ret['returnStatus'] = "Customer Not Updated";

		// Return the array as a JSON object
		echo json_encode($ret);

		// Break out of the PHP script
		die();

	}

	// Customer was updated successfully
	$ret['returnStatus'] = "Customer Updated";

	// Return the array as a JSON object
	echo json_encode($ret);

	// Close the database connection
	$db->close();

?>