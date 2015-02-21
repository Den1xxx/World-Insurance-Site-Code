<?php

	// Determine site content root
	$webroot = dirname(dirname(__FILE__));

	$configDatabaseName     = $_POST[ 'inputDatabaseName' ];
	$configDatabaseUserName = $_POST[ 'inputDatabaseUserName' ];
	$configDatabaseUserPass = $_POST[ 'inputDatabaseUserPass' ];
	$configDatabaseHostname = $_POST[ 'inputDatabaseHostname' ];

	$configSiteName = "World Insurance";

	$configTblCustomer = "tblCustomer";
	$configTblUser = "tblUser";
	$configTblPolicy = "tblPolicy";
	$configTblConfig = "tblConfig";

	$ifp = fopen( $webroot . "/config.php", "w" ) or die( "Unable to open file!" );

	$txt = "<?php

	// Website top level directory path
	define('TOP_PATH', '$webroot');

	";
	fwrite($ifp, $txt);

	$txt =
	"  /*
	* MySQL settings
	*/

	// MySQL database name
	define('DB_NAME', '$configDatabaseName');

	// MySQL database username
	define('DB_USER', '$configDatabaseUserName');

	// MySQL database password
	define('DB_PASSWORD', '$configDatabaseUserPass');

	// MySQL hostname
	define('DB_HOST', '$configDatabaseHostname');

	// Database Charset to use in creating database tables.
	define('DB_CHARSET', 'utf8');

	// The Database Collate type.
	define('DB_COLLATE', '');

	/*
	* App Config
	*/

	// Website Name
	define('SITE_NAME', '$configSiteName');

	// Customers table name
	define('TBL_CUSTOMER', '$configTblCustomer');

	// Users table name
	define('TBL_USER', '$configTblUser');

	// Policies table name
	define('TBL_POLICY', '$configTblPolicy');
	
	// Config table name
	define('TBL_CONFIG', '$configTblConfig');

?>
";

	fwrite($ifp, $txt);
	fclose($ifp);

	$configExists = file_exists( $webroot . "/config.php" );

	return $configExists;

?>