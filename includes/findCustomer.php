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

	// Creates a new Database object, and then establishes a connection to the
	// Database
	$dbObject = new Database;
	$db = $dbObject->createDatabaseConnection();

	// Checks the database connection
	if ($db->connect_errno) {

		// Logs the connection error
		error_log( "Connection failed: " . $db->connect_error );

		// Add the error to the return array
		$ret["returnStatus"] = "Fail";
		$ret["errorLog"] = "Connection failed: " . $db->connect_error;

		// Return the array as a JSON object
		echo json_encode($ret);

		// Break out of the PHP script
		die();

	}

	// Save the inputs to variables
	$customerAccountNumber = $_GET[ 'inputSearchAccountNumber' ];
	$customerFirstName     = $_GET[ 'inputSearchFirstName' ];
	$customerLastName      = $_GET[ 'inputSearchLastName' ];
	$customerZip           = $_GET[ 'inputSearchZip' ];

	// Sanitize all the input
	$customerAccountNumber = $db->real_escape_string($customerAccountNumber);
	$customerFirstName     = $db->real_escape_string($customerFirstName);
	$customerLastName      = $db->real_escape_string($customerLastName);
	$customerZip           = $db->real_escape_string($customerZip);

	// Checks if any input was received
	if($customerAccountNumber == "" && $customerFirstName == ""
		&& $customerLastName == "" && $customerZip == "") {

		// No input received, set the return status to "No results"
		$ret['returnStatus'] = "No results";

		// Return the array as a JSON object
		echo json_encode($ret);

		// Break out of the PHP script
		die();

	}

	// Checks if any of the input is empty, if so, set the input to a value that
	// would not exist in the database
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

	// Build the SQL query that will be used to grab ALL relevant results from
	// the received input.
	//
	// Note: Keep in mind that this is an OR, so any partial matches to any of
	// the inputs will be grabbed from the database
	$SQLQuery = "SELECT * FROM `" . DB_NAME . "`.`" . TBL_CUSTOMER . "` " .
		"WHERE (`accountNumber` LIKE " .
		"'%$customerAccountNumber%' OR `customerFirstName` LIKE " .
		"'%$customerFirstName%' OR `customerLastName` LIKE " .
		"'%$customerLastName%' OR `customerZip` LIKE '%$customerZip%') " .
		"ORDER BY `accountNumber` DESC;";

	// Execute the query on the database object
	$result = $db->query($SQLQuery);

	// Checks to see if any customers were found (there should be at least one
	// row returned if a customer was found)
	if ($result->num_rows == 0) {

		// No customers found, set the return status to "No results"
		$ret['returnStatus'] = "No results";

		// Return the array as a JSON object
		echo json_encode($ret);

		// Break out of the PHP script
		die();

	}

	// Sets up some variables for the returned customers
	$count = 0;
	$modal = "";
	$table = "";

	// Iterate through all returned customers
	while($row = $result->fetch_row()) {

		// Increments the count, this helps with the auto-generated modals and
		// distinguishing their names with this count
		$count++;

		$accountNumber = $row[1];
		$firstName     = $row[2];
		$lastName      = $row[3];
		$zip           = $row[4];

		// Set up the current modals variables (pretty much their unique names)
		$currentModalName                = "view" . $count . "CustomerModal";
		$currentModalNameBtn             = "#" . $currentModalName;
		$currentModalAlert               = $currentModalName . "Alert";
		$currentModalNameForm            = $currentModalName . "Form";
		$currentModalLabelName           = $currentModalName . "Label";
		$curentModalNameBtnAccountNumber = $currentModalNameBtn . "AccountNumber";

		// Save all auto-generated modals for each returned customer
		$modal .=
			"<!-- $currentModalName Modal -->" .
			"<div class=\"modal fade\" id=\"$currentModalName\" tabindex=\"-1\" " .
				"role=\"dialog\" aria-labelledby=\"$currentModalLabelName\" " .
				"aria-hidden=\"true\">" .
			"	<div class=\"modal-dialog modal-lg\">" .
			"		<div class=\"modal-content\">" .
			"			<div class=\"modal-header\">" .
			"				<button type=\"button\" class=\"close\" " .
								"data-dismiss=\"modal\" aria-label=\"Close\">" .
			"					<span aria-hidden=\"true\">&times;</span>" .
			"				</button>" .
			"				<h4 class=\"modal-title\" id=\"$currentModalLabelName\">" .
								"$firstName $lastName's Policy Info</h4>" .
			"			</div>" .
			"			<div class=\"modal-body\">" .
			"				<div id=\"$currentModalAlert\" class=\"hidden\" " .
								"role=\"alert\" />" .
			"				<form class=\"form-left\" id=\"$currentModalNameForm\"" .
								" enctype=\"multipart/form-data\" " .
								"onsubmit=\"modalGenSubmit()\">" .
			"					<div class=\"form-group form-inline\">" .
			"						<div class=\"input-group col-xs-4\">" .
			"							<label for=\"inputGenModalFirstName\">" .
											"First Name</label>" .
			"							<input type=\"text\" " .
											"id=\"inputGenModalFirstName\" " .
											"name=\"inputGenModalFirstName\" " .
											"class=\"form-control " .
											"form-single-lg-margin\" " .
											"value=\"$firstName\" " .
											"autocomplete=\"off\" />" .
			"						</div>" .
			"						<div class=\"input-group col-xs-4\">" .
			"							<label for=\"inputGenModalLastName\">" .
											"Last Name</label>" .
			"							<input type=\"text\" " .
											"id=\"inputGenModalLastName\" " .
											"name=\"inputGenModalLastName\" " .
											"class=\"form-control " .
											"form-single-lg-margin\" " .
											"value=\"$lastName\" autocomplete=\"off\" />" .
			"						</div>" .
			"					</div>" .
			"					<div class=\"form-group form-inline\">" .
			"						<div class=\"input-group col-xs-2\">" .
			"							<label for=\"inputGenModalAccountNumber\">" .
											"Account Number</label>" .
			"							<input type=\"text\" " .
											"id=\"inputGenModalAccountNumber\" " .
											"name=\"inputGenModalAccountNumber\" " .
											"class=\"form-control " .
											"form-single-lg-margin\" " .
											"value=\"$accountNumber\" " .
											"autocomplete=\"off\" />" .
			"						</div>" .
			"					</div>" .
			"					<div class=\"form-group form-inline\">" .
			"						<div class=\"input-group col-xs-1\">" .
			"							<label for=\"inputGenModalZip\">Zip</label>" .
			"							<input type=\"text\" id=\"inputGenModalZip\" " .
											"name=\"inputGenModalZip\" " .
											"class=\"form-control " .
											"form-single-lg-margin\" " .
											"value=\"$zip\" autocomplete=\"off\" />" .
			"						</div>" .
			"					</div>" .
			"					<div class=\"form-group form-inline\">" .
			"						<label for=\"inputDatePickerStart\">Policy " .
										"Start Date to Policy End Date</label>" .
			"						<div class=\"input-daterange input-group " .
										"col-xs-3\" id=\"datePicker\">" .
   		"							<input type=\"text\" class=\"form-control\" " .
   										"id=\"inputGenModalDatePickerStart\" " .
   										"name=\"inputGenModalDatePickerStart\" " .
   										"data-provide=\"datepicker\" " .
   										"data-date-today-btn=\"linked\" " .
   										"data-date-autoclose=\"true\" " .
   										"data-date-today-highlight=\"true\" />" .
   		"							<span class=\"input-group-addon\">to</span>" .
   		"							<input type=\"text\" class=\"form-control\" " .
   										"id=\"inputGenModalDatePickerEnd\" " .
   										"name=\"inputGenModalDatePickerEnd\" " .
   										"data-provide=\"datepicker\" " .
   										"data-date-today-btn=\"linked\" " .
   										"data-date-autoclose=\"true\" " .
   										"data-date-today-highlight=\"true\" />" .
			"						</div>" .
			"					</div>" .
			"					<div class=\"form-group form-inline\">" .
			"						<div class=\"input-group col-xs-3\">" .
			"							<label for=\"inputGenModalFile\">Upload Policy " .
											"PDF</label>" .
			"							<input type=\"file\" id=\"inputGenModalFile\" " .
											"name=\"inputGenModalFile\" size=\"20\" />" .
			"							<p class=\"help-block\">Please upload a PDF for" .
											" the policy period chosen above!</p>" .
			"						</div>" .
			"					</div>" .
			"				</form>" .
			"			</div>" .
			"			<div class=\"modal-footer\">" .
			"				<button type=\"button\" class=\"btn btn-default\" " .
								"data-dismiss=\"modal\" onclick=\"searchCustomer();\"" .
								">Close</button>" .
			"				<button type=\"button\" class=\"btn btn-primary\" " .
								"onclick=\"modalGenButton($currentModalNameForm, " .
								"$currentModalAlert)\">Update</button>" .
			"			</div>" .
			"		</div>" .
			"	</div>" .
			"</div>";

		// Save all the auto-generated table rows for each returned customer
		$table .=
			"<tr>" .
			"   <td>$accountNumber</td>" .
			"   <td>$firstName</td>" .
			"   <td>$lastName</td>" .
			"   <td>$zip</td>" .
			"   <td><button type=\"button\" class=\"btn btn-xs btn-info\" " .
					"data-toggle=\"modal\" data-target=\"$currentModalNameBtn\">" .
					"View</button>&nbsp;&nbsp;<button type=\"button\" class=\"btn " .
					"btn-xs btn-danger\" " .
					"onclick=\"searchCustomerDelButton($accountNumber)\">Delete" .
					"</button></td>" .
			"</tr>";

	}

	// Set the generated modal and table strings to the return object
	$returnObject = array(
		'modalOutput' => $modal,
		'tableOutput' => $table
	);

	// JSON encode the return object, and set the return status to "Success"
	$ret['returnObject'] = json_encode($returnObject);
	$ret['returnStatus'] = "Success";

	// Return the array as a JSON object
	echo json_encode($ret);

	// Close the returned result
	$result->close();

	// Close the database connection
	$db->close();

?>
