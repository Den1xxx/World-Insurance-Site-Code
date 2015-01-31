<?php

    // Determine site content root
    define('__ROOT__', dirname(__FILE__));
    
   $currentPage = $_SERVER['REQUEST_URI'];
   $out = "";
   
   $out .=
       "<div class=\"col-sm-3 col-md-2 sidebar\">" .
        "   <ul class=\"nav nav-sidebar\">";
   
   if( $currentPage == "/admin" || $currentPage == "/account/policies.php" ) {
   
        $out .=
            "       <li class=\"active\"><a href=\"../admin\">Dashboard <span class=\"sr-only\">(current)</span></a></li>";
   
   }
   else {
   
        $out .=
            "       <li><a href=\"../admin\">Dashboard <span class=\"sr-only\">(current)</span></a></li>";
   
   }
   
   $out .=
       "        <li><a href=\"\">Reports</a></li>" .
       "        <li><a href=\"\">Analytics</a></li>" .
       "        <li><a href=\"\">Export</a></li>" .
       "    </ul>" .
       "    <ul class=\"nav nav-sidebar\">" .
       "        <li><a href=\"../admin/searchCustomer.php\">Search Customers</a></li>" .
       "        <li><a href=\"../admin/addCustomer.php\">Add Customers</a></li>" .
       "    </ul>" .
       "    <ul class=\"nav nav-sidebar\">" .
       "        <li><a href=\"\">Nav item again</a></li>" .
       "        <li><a href=\"\">One more nav</a></li>" .
       "        <li><a href=\"\">Another nav item</a></li>" .
       "    </ul>" .
       "</div>";
   
   echo $out;

?>