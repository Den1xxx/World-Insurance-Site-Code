<?php

	// Determine site content root
	define('__ADUSROOT__', dirname(dirname(__FILE__)));

	require_once( __ADUSROOT__ . "/config.php" );
	require_once( __ADUSROOT__ . "/includes/database.php" );
	require_once( __ADUSROOT__ . "/includes/createHash.php" );

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

	$newUserEmail         = $_POST[ 'inputUserEmail' ];
	$newUserPass          = $_POST[ 'inputUserPass' ];
	$newUserAccountNumber = $_POST[ 'inputUserAccountNumber' ];
	$newIsAdmin           = $_POST[ 'inputIsAdmin' ];
	$hashUserPass         = create_hash("$newUserPass");

	$preppedNewUserEmail         = $db->real_escape_string($newUserEmail);
	$preppedNewUserPass          = $db->real_escape_string($hashUserPass);
	$preppedNewUserAccountNumber = $db->real_escape_string($newUserAccountNumber);
	$preppedNewIsAdmin           = $db->real_escape_string($newIsAdmin);

	$SQLQuery = "INSERT INTO `" . DB_NAME . "`.`CM_Users` (" .
		"`userRecordID`," .
		"`isAdmin`," .
		"`userEmail`," .
		"`userPassword`," .
		"`accountNumber`" .
		") VALUES (" .
			"NULL," .
			"'$preppedNewIsAdmin'," .
			"'$preppedNewUserEmail'," .
			"'$preppedNewUserPass'," .
			"'$preppedNewUserAccountNumber');";

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