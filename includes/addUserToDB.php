<?php

	// Determine site content root
	$webroot = dirname(dirname(__FILE__));

	require_once( $webroot . "/config.php" );
	require_once( $webroot . "/includes/database.php" );
	require_once( $webroot . "/includes/createHash.php" );

	// Setups up return array
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

	$newUserEmail             = $_POST[ 'inputUserEmail' ];
	$newUserPass              = $_POST[ 'inputUserPass' ];
	$existingcustomerRecordID = $_POST[ 'inputCustomerRecordID' ];
	$newIsAdmin               = $_POST[ 'inputIsAdmin' ];
	$hashUserPass             = create_hash("$newUserPass");

	$newUserEmail             = $db->real_escape_string($newUserEmail);
	$hashUserPass             = $db->real_escape_string($hashUserPass);
	$existingcustomerRecordID = $db->real_escape_string($existingcustomerRecordID);
	$newIsAdmin               = $db->real_escape_string($newIsAdmin);

	$SQLQuery = "INSERT INTO `" . DB_NAME . "`.`" . TBL_USER . "` (" .
		"`userRecordID`," .
		"`isAdmin`," .
		"`userEmail`," .
		"`userPassword`," .
		"`customerRecordID`" .
		") VALUES (" .
			"NULL," .
			"'$newIsAdmin'," .
			"'$newUserEmail'," .
			"'$hashUserPass'," .
			"'$existingcustomerRecordID');";

	if ( $db->query($SQLQuery) === FALSE ) {

		error_log( "Error creating record: " . $db->error );

		$ret["returnStatus"] = "Fail";
		$ret["errorLog"] = "Error finding record: " . $db->error;

		echo json_encode($ret);

	}

	$db->close();

	$ret["returnStatus"] = "Success";

	echo json_encode($ret);

?>
