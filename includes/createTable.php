<?php

	// Determine site content root
	define('__ROOT__', dirname(dirname(__FILE__)));

	$configExists = file_exists( __ROOT__ . "/config.php" );

	// Checks to make sure the config file was written successfully
	if ( $configExists ) {

		require_once( __ROOT__ . "/config.php" );
		require_once( __ROOT__ . "/includes/database.php" );

	}
	else {

		error_log( "NO CONFIG" );
		return FALSE;

	}

	$dbObject = new Database;
	$db = $dbObject->createDatabaseConnection();

	// Checks the database connection
	if ($db->connect_errno) {

		error_log( "Connection failed: " . $db->connect_error );
		return FALSE;

	}

	$SQLQuery = "CREATE TABLE `" . TBL_CUSTOMER . "` (
		`customerRecordID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		`accountNumber` int(9) unsigned NOT NULL,
		`customerFirstName` varchar(100) CHARACTER SET utf8 NOT NULL,
		`customerLastName` varchar(100) CHARACTER SET utf8 NOT NULL,
		`customerZip` mediumint(5) unsigned NOT NULL,
		PRIMARY KEY (`customerRecordID`),
		UNIQUE KEY `accountNumber` (`accountNumber`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ( $db->query($SQLQuery) === FALSE ) {

		 error_log( "Error creating table: " . $db->error );
		 return FALSE;

	}

	$SQLQuery = "CREATE TABLE `" . TBL_USER . "` (
		`userRecordID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		`isAdmin` BOOLEAN NOT NULL,
		`userEmail` varchar(100) CHARACTER SET utf8 NOT NULL,
		`userPassword` mediumtext CHARACTER SET utf8 NOT NULL,
		`customerRecordID` bigint(20) unsigned NOT NULL,
		PRIMARY KEY (`userRecordID`),
		FOREIGN KEY (`customerRecordID`) REFERENCES " . TBL_CUSTOMER . 
			"(`customerRecordID`),
		UNIQUE KEY `userEmail` (`userEmail`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ( $db->query($SQLQuery) === FALSE ) {

		error_log( "Error creating table: " . $db->error );
		return FALSE;

	}
	
	$SQLQuery = "CREATE TABLE `" . TBL_POLICY . "` (
		`policyRecordID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		`policyNumber` int(9) unsigned NOT NULL,
		`customerRecordID` bigint(20) unsigned NOT NULL,
		PRIMARY KEY (`policyRecordID`),
		FOREIGN KEY (`customerRecordID`) REFERENCES " . TBL_CUSTOMER . 
			"(`customerRecordID`),
		UNIQUE KEY `policyNumber` (`policyNumber`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ( $db->query($SQLQuery) === FALSE ) {

		error_log( "Error creating table: " . $db->error );
		return FALSE;

	}

	$db->close();

	return TRUE;

?>