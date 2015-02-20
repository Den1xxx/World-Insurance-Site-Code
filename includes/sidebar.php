<?php

	// Determine site content root
	$webroot = dirname(__FILE__);

   $currentPage = $_SERVER['REQUEST_URI'];
   $out = "";

   $out .=
	   "<div class=\"col-sm-3 col-md-2 sidebar\">" .
		"   <ul class=\"nav nav-sidebar\">";

   if( $currentPage == "/admin" ||  $currentPage == "/admin/" ) {

		$out .=
			"       <li class=\"active\"><a href=\"../admin\">Dashboard <span class=\"sr-only\">(current)</span></a></li>";

   }
   else {

		$out .=
			"       <li><a href=\"../admin\">Dashboard <span class=\"sr-only\">(current)</span></a></li>";

   }

   if( $currentPage == "/admin/searchCustomer.php" ) {

	   $out .=
		   "        <li class=\"active\"><a href=\"../admin/searchCustomer.php\">Search Customers</a></li>";

   }
   else {

	   $out .=
		   "        <li><a href=\"../admin/searchCustomer.php\">Search Customers</a></li>";

   }

   if( $currentPage == "/admin/addCustomer.php" ) {

		$out .=
			"        <li class=\"active\"><a href=\"../admin/addCustomer.php\">Add Customers</a></li>";

   }
   else {

		$out .=
			"        <li><a href=\"../admin/addCustomer.php\">Add Customers</a></li>";

   }

   $out .=
	   "    </ul>";
	   
	$out .=
		"   <ul class=\"nav nav-sidebar\">";

   if( $currentPage == "/admin/frontPage.php" ) {

		$out .=
			"       <li class=\"active\"><a href=\"../admin/frontPage.php\">Edit Front Page <span class=\"sr-only\">(current)</span></a></li>";

   }
   else {

		$out .=
			"       <li><a href=\"../admin/frontPage.php\">Edit Front Page <span class=\"sr-only\">(current)</span></a></li>";

   }

   $out .=
	   "    </ul>" .
	   "</div>";

   echo $out;

?>