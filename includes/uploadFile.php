<<?php

     // Determine site content root
     define('__ROOT__', dirname(dirname(__FILE__)));

     require_once( __ROOT__ . "/config.php" );

     // Sets up return array
     $ret = array(
         'returnStatus' => "",
         'errorLog' => ""
     );

 ?>