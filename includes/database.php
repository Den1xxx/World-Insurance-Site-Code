<?php

   // Determine site content root
   define('__DAROOT__', dirname(dirname(__FILE__)));

   require_once( __DAROOT__ . "/config.php" );

   class Database {

      public function createDatabaseConnection() {

         $db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

         // Check connection
         if( mysqli_connect_errno() ) {

            return "Failed to connect to MySQL: " . mysqli_connect_error();

         }

         return $db;

      }

   }

?>
