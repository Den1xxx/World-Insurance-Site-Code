<?php

	// Starts a new session
	ob_start();
	session_start();

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
	$db       = $dbObject->createDatabaseConnection();

	// Checks the database connection
	if ($db->connect_errno) {

		error_log( "Connection failed: " . $db->connect_error );

		$ret["returnStatus"] = "Fail";
		$ret["errorLog"]     = "Connection failed: " . $db->connect_error;

		echo json_encode($ret);

	}

	$loginUserEmail = $_POST[ 'inputLoginEmail' ];
	$loginUserPass  = $_POST[ 'inputLoginUserPass' ];

	$preppedLoginUserEmail = $db->real_escape_string($loginUserEmail);
	$preppedLoginUserPass  = $db->real_escape_string($loginUserPass);

	$SQLQuery = "SELECT * FROM `" . DB_NAME . "`.`" . TBL_USER . "`" .
		"WHERE `userEmail` = '$preppedLoginUserEmail';";

	$result = $db->query($SQLQuery);

	if ( $result === FALSE ) {

		error_log( "Error finding user record: " . $db->error );

		$ret["returnStatus"] = "Fail User";
		$ret["errorLog"]     = "Error finding user record: " . $db->error;

		echo json_encode($ret);

	}
	else {

		// Fetch returned row
		$row = $result->fetch_row();

		// Close the returned result
		$result->close();

		if( $row[2] == $preppedLoginUserEmail &&
			validate_password($preppedLoginUserPass, $row[3])  ) {

			$_SESSION["userEmail"]     = "$row[2]";
			$_SESSION["isAdmin"]       = "$row[1]";
			$_SESSION["accountNumber"] = "$row[4]";

			$accountNumber = "$row[4]";

			$SQLQuery = "SELECT * FROM `" . DB_NAME . "`.`" . TBL_CUSTOMER . "`" .
				"WHERE `accountNumber` = '$accountNumber';";

			$result = $db->query($SQLQuery);

			if ( $result === FALSE ) {

				error_log( "Error finding customer record: " . $db->error );

				$ret["returnStatus"] = "Fail Customer";
				$ret["errorLog"]     = "Error finding customer record: " .
					$db->error;

				echo json_encode($ret);

			}
			else {

				// Fetch returned row
				$row = $result->fetch_row();

				// Close the returned result
				$result->close();

				$_SESSION["firstName"]             = "$row[2]";
				$_SESSION["lastName"]              = "$row[3]";
				$_SESSION["zip"]                   = "$row[4]";
				$_SESSION["customerPolicyNumbers"] = "$row[5]";
				$_SESSION["customerPolicyPDFs"]    = "$row[6]";

				$ret["returnStatus"] = "Success";

				echo json_encode($ret);

			}

		}
		else {

			$ret["returnStatus"] = "Fail User";
			$ret["errorLog"]     = "Bad login";

			echo json_encode($ret);

		}

	}

	// Close the database connection
	$db->close();

?>