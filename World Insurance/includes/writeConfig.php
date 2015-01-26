<?php
   
    // Determine site content root
    define('__ROOT__', dirname(dirname(__FILE__)));
   
    $newDatabaseName     = $_POST[ 'inputDatabaseName' ];
	$newDatabaseUserName = $_POST[ 'inputDatabaseUserName' ];
	$newDatabaseUserPass = $_POST[ 'inputDatabaseUserPass' ];
	$newDatabaseHostname = $_POST[ 'inputDatabaseHostname' ];
   
   $configDatabaseName     = "'" . "$newDatabaseName" . "'";
   $configDatabaseUserName = "'" . "$newDatabaseUserName" . "'";
   $configDatabaseUserPass = "'" . "$newDatabaseUserPass" . "'";
   $configDatabaseHostname = "'" . "$newDatabaseHostname" . "'";
   
   $ifp = fopen( __ROOT__ . "/config.php", "w" ) or die( "Unable to open file!" );
   
   $txt = "<?php
   
   // Website top level directory path
   define('TOP_PATH', '/');
   
   ";
   fwrite($ifp, $txt);
   
   $txt = "// ** MySQL settings - You can get this info from your web host ** //
   /** The name of the database for WordPress */
   define('DB_NAME', $configDatabaseName);
   
   /** MySQL database username */
   define('DB_USER', $configDatabaseUserName);
   
   /** MySQL database password */
   define('DB_PASSWORD', $configDatabaseUserPass);
   
   /** MySQL hostname */
   define('DB_HOST', $configDatabaseHostname);
   
   /** Database Charset to use in creating database tables. */
   define('DB_CHARSET', 'utf8');
   
   /** The Database Collate type. Don't change this if in doubt. */
   define('DB_COLLATE', '');
   
?>
   ";
   fwrite($ifp, $txt);
   fclose($ifp);
   
   $configExists = file_exists( __ROOT__ . "/config.php" );
   
   return $configExists;
   
?>