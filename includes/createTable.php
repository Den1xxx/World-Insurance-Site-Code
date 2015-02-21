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
			"(`customerRecordID`) ON DELETE CASCADE,
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
			"(`customerRecordID`) ON DELETE CASCADE,
		UNIQUE KEY `policyNumber` (`policyNumber`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ( $db->query($SQLQuery) === FALSE ) {

		error_log( "Error creating table: " . $db->error );
		return FALSE;

	}
	
	$SQLQuery = "CREATE TABLE `" . TBL_CONFIG . "` (
		`configRecordID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		`configName` varchar(100) CHARACTER SET utf8 NOT NULL,
		`configValue` varchar(100) CHARACTER SET utf8 NOT NULL,
		PRIMARY KEY (`configRecordID`),
		UNIQUE KEY `configName` (`configName`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		
	if ( $db->query($SQLQuery) === FALSE ) {

		error_log( "Error creating table: " . $db->error );
		return FALSE;

	}
	
	$SQLQuery = "INSERT INTO `" . DB_NAME . "`.`" . TBL_CONFIG . "` (" .
		"`configRecordID`," .
		"`configName`," .
		"`configValue`" .
		") VALUES (" .
			"NULL," .
			"'siteName'," .
			"'Site Name');";
			
	if ( $db->query($SQLQuery) === FALSE ) {

		error_log( "Error adding site name to db: " . $db->error );
		return FALSE;

	}
	
	$SQLQuery = "INSERT INTO `" . DB_NAME . "`.`" . TBL_CONFIG . "` (" .
		"`configRecordID`," .
		"`configName`," .
		"`configValue`" .
		") VALUES (" .
			"NULL," .
			"'sloganHTML'," .
			"'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce " .
				"dapibus, tellus ac cursus commodo, tortor mauris condimentum " .
				"nibh, ut fermentum massa justo sit amet risus.');";
			
	if ( $db->query($SQLQuery) === FALSE ) {

		error_log( "Error adding site slogan to db: " . $db->error );
		return FALSE;

	}

	$db->close();

	return TRUE;

?>