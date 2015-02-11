<?php

	// Determine site content root
	$webroot = dirname(dirname(__FILE__));

	require_once( $webroot . "/config.php" );
	require_once( $webroot . "/includes/database.php" );
	require_once( $webroot . "/includes/createHash.php" );

	$dbObject = new Database;
	$db = $dbObject->createDatabaseConnection();

	// Checks the database connection
	if ($db->connect_errno) {

		error_log( "Connection failed: " . $db->connect_error );
		return FALSE;

	}

	$findUserRecordID      = $_GET[ 'inputUserRecordID' ];
	$findUserEmail         = $_GET[ 'inputUserEmail' ];
	$findUserPass          = $_GET[ 'inputUserPass' ];
	$findUserAccountNumber = $_GET[ 'inputUserAccountNumber' ];

	$preppedFindUserRecordID      = $db->real_escape_string($findUserRecordID);
	$preppedFindUserEmail         = $db->real_escape_string($findUserEmail);
	$preppedFindUserPass          = $db->real_escape_string($findUserPass);
	$preppedFindUserAccountNumber = $db->real_escape_string($findUserAccountNumber);

	$SQLQuery = "SELECT * FROM `" . DB_NAME . "`.`" . TBL_USER . "` " .
		"WHERE userRecordID = $preppedFindUserRecordID;";

	if ( $result = $db->query($SQLQuery) === FALSE ) {

		error_log( "Error finding record: " . $db->error );
		return "Ended badly";

	}

	$db->close();

	//return $result;
	return "ended well";

?>
