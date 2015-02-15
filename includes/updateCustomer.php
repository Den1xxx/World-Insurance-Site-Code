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

	// Checks to see if the user uploaded a PDF
	if($_FILES[ 'inputGenModalFile' ][ 'name' ]) {

		if(!$_FILES[ 'inputGenModalFile' ][ 'error' ]) {
			
			// Save the date picker inputs to variables
			$customerDatePickerStart = $_POST[ 'inputGenModalDatePickerStart' ];
			$customerDatePickerEnd   = $_POST[ 'inputGenModalDatePickerEnd' ];
			
			// Sanitize the date picker inputs
			$customerDatePickerStart
				= $db->real_escape_string($customerDatePickerStart);
			$customerDatePickerEnd
				= $db->real_escape_string($customerDatePickerEnd);
				
			// Remove any slashes that exist
			$customerDatePickerStart = str_replace("/", "", 
				$customerDatePickerStart);
			$customerDatePickerEnd   = str_replace("/", "", 
				$customerDatePickerEnd);

			// Generate a new file name for this policy PDF
			// The name format is MMDDYYYY-MMDDYYYY
			// The name format is always the policy start date "-" policy end date
			$policyPDFName = $customerDatePickerStart . "-" . 
				$customerDatePickerEnd . ".pdf";

			// Checks to make sure the PDF is larger than 20MBs
			if($_FILES[ 'inputGenModalFile' ][ 'size' ] > 20971520) {

				$isFileValid = false;

				// Add the error to the return array
				$ret["returnStatus"] = "You uploaded a PDF that is too large";

			}
			else {

				$isFileValid = true;

			}

			if($isFileValid) {

				// Checks to see if the target directory exists
				if( !file_exists("../uploads/$customerAccountNumber") ) {

					mkdir("../uploads/$customerAccountNumber", 0775);

				}

				// Moves the PDF from tmp to its final resting place
				move_uploaded_file($_FILES[ 'inputGenModalFile' ][ 'tmp_name' ],
					"../uploads/$customerAccountNumber/$policyPDFName");

				// Sets the file uploaded to true
				$ret["fileUploaded"] = true;

			}

		}
		else {

			// Add the error to the return array
			$ret["returnStatus"] = "Upload Failed";
			$ret["errorLog"] = "Your upload failed with the following error: " .
				$_FILES[ 'inputGenModalFile' ][ 'error' ];

		}

	}

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