<?php

	// Starts a new session
	ob_start();
	session_start();

	// Determine site content root
	$webroot = dirname(dirname(__FILE__));

	require_once( $webroot . "/config.php" );
	require_once( $webroot . "/includes/database.php" );

	// Sets up return array
	$ret = array(
		'returnObject' => "",
		'returnStatus' => "",
		'errorLog' => ""
	);

	$dbObject = new Database;
	$db = $dbObject->createDatabaseConnection();

	// Checks the database connection
	if ($db->connect_errno) {

		error_log( "Connection failed: " . $db->connect_error );

		$ret["returnStatus"] = "Fail";
		$ret["errorLog"] = "Connection failed: " . $db->connect_error;

		echo json_encode($ret);

	}

	$customerAccountNumber  = $_GET[ 'inputSearchAccountNumber' ];
	$customerFirstName      = $_GET[ 'inputSearchFirstName' ];
	$customerLastName       = $_GET[ 'inputSearchLastName' ];
	$customerZip            = $_GET[ 'inputSearchZip' ];

	if($customerAccountNumber == "" && $customerFirstName == "" && $customerLastName == "" && $customerZip == "") {

		$ret['returnStatus'] = "No results";

		echo json_encode($ret);
		die();

	}
	else {

		if($customerAccountNumber == "") {

			$customerAccountNumber = "999999999";

		}
		if($customerFirstName == "") {

			$customerFirstName = "NULL";

		}
		if($customerLastName == "") {

			$customerLastName = "NULL";

		}
		if($customerZip == "") {

			$customerZip = "NULL";

		}

	}

	$SQLQuery = "SELECT * FROM `cm`.`CM_Customers` WHERE (`accountNumber` LIKE" .
		" '%$customerAccountNumber%' OR `customerFirstName` LIKE" .
		" '%$customerFirstName%' OR `customerLastName` LIKE" .
		" '%$customerLastName%' OR `customerZip` LIKE '%$customerZip%')" .
		" ORDER BY `accountNumber` DESC;";

	$result = $db->query($SQLQuery);

	if ($result->num_rows == 0) {

		$ret['returnStatus'] = "No results";

		echo json_encode($ret);
		die();

	}

	$count = 0;
	$modal = "";
	$table = "";

	while($row = $result->fetch_row()) {

		$count++;
		$innerModalFieldEditCount = 4;

		$accountNumber  = $row[1];
		$firstName      = $row[2];
		$lastName       = $row[3];
		$zip            = $row[4];

		$currentModalName = "view" . "$count" . "CustomerModal";
		$currentModalNameBtn = "#" . $currentModalName;
		$currentModalLabelName = "$currentModalName" . "Label";
		$curentModalNameBtnAccountNumber = $currentModalNameBtn . "AccountNumber";

		$modal .=
			"<!-- $currentModalName Modal -->" .
			"<div class=\"modal fade\" id=\"$currentModalName\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"$currentModalLabelName\" aria-hidden=\"true\">" .
			"	<div class=\"modal-dialog\">" .
			"		<div class=\"modal-content\">" .
			"			<div class=\"modal-header\">" .
			"				<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">" .
			"					<span aria-hidden=\"true\">&times;</span>" .
			"				</button>" .
			"               <h4 class=\"modal-title\" id=\"$currentModalLabelName\">$firstName $lastName's Policy Info</h4>" .
			"           </div>" .
			"           <div class=\"modal-body\">" .
			"               <form class=\"form-signin\" id=\"$currentModalName\" onsubmit=\"modalGenSubmit()\">" .
			"                   <div class=\"table-responsive\">" .
			"                       <table class=\"table\">" .
			"                           <thead>" .
			"                               <tr>" .
			"                                   <th>Account #</th>" .
			"                                   <th>First Name</th>" .
			"                                   <th>Last Name</th>" .
			"                                   <th>Zip</th>" .
			"                               </tr>" .
			"                           </thead>" .
			"                           <tbody>" .
			"                               <tr>" .
			"                                   <td>" .
			"                                       <label for=\"inputGenModalAccountNumber\" class=\"sr-only\">Account Number</label>" .
			"                                       <input type=\"text\" id=\"inputGenModalAccountNumber\" name=\"inputGenModalAccountNumber\" class=\"form-control form-middle\" value=\"$accountNumber\" autocomplete=\"off\" />" .
			"                                   </td>" .
			"                                   <td>" .
			"                                       <label for=\"inputGenModalFirstName\" class=\"sr-only\">First Name</label>" .
			"                                       <input type=\"text\" id=\"inputGenModalFirstName\" name=\"inputGenModalFirstName\" class=\"form-control form-middle\" value=\"$firstName\" autocomplete=\"off\" />" .
			"                                   </td>" .
			"                                   <td>" .
			"                                       <label for=\"inputGenModalLastName\" class=\"sr-only\">Last Name</label>" .
			"                                       <input type=\"text\" id=\"inputGenModalLastName\" name=\"inputGenModalLastName\" class=\"form-control form-middle\" value=\"$lastName\" autocomplete=\"off\" />" .
			"                                   </td>" .
			"                                   <td>" .
			"                                       <label for=\"inputGenModalZip\" class=\"sr-only\">Zip</label>" .
			"                                       <input type=\"text\" id=\"inputGenModalZip\" name=\"inputGenModalZip\" class=\"form-control form-middle\" value=\"$zip\" autocomplete=\"off\" />" .
			"                                   </td>" .
			"                               </tr>" .
			"                           </tbody>" .
			"                       </table>" .
			"                   </div>" .
			"               </form>" .
			"           </div>" .
			"           <div class=\"modal-footer\">" .
			"               <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>" .
			"               <button type=\"submit\" class=\"btn btn-primary\">Update</button>" .
			"           </div>" .
			"       </div>" .
			"   </div>" .
			"</div>";

		$table .=
			"<tr>" .
			"   <td>$accountNumber</td>" .
			"   <td>$firstName</td>" .
			"   <td>$lastName</td>" .
			"   <td>$zip</td>" .
			"   <td><button type=\"button\" class=\"btn btn-xs btn-info\" data-toggle=\"modal\" data-target=\"$currentModalNameBtn\">View</button></td>" .
			"</tr>";

	}

	$returnObject = array(
		'modalOutput' => $modal,
		'tableOutput' => $table
	);

	$ret['returnObject'] = json_encode($returnObject);
	$ret['returnStatus'] = "Success";

	echo json_encode($ret);

	// Close the returned result
	$result->close();

	// Close the database connection
	$db->close();

?>
