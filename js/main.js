/* Main JavaScript functions for the site
 * If it ain't here, it ain't nowhere ;)
 *
 * Author: techsym
 * Maintainer: techsym
 * Version: 0.0.1
 * Version Date: 01/18/2015
 *
 */

// Allow buttons on auto generated modal forms to be clickable, also passes the
// form that the button belongs to as an argument
function modalGenButton(modalFormName, modalOutputName) {

	modalGenSubmit(modalFormName, modalOutputName);

}

// Allow auto generated modal forms to be submittable
function modalGenSubmit(modalFormName, modalOutputName) {

	var serializedData = $(modalFormName).serialize();

	// Fire off the POST request to updateCustomer.php
	var req = $.ajax({

		url: "../includes/updateCustomer.php",
		type: "POST",
		data: serializedData

	});

	// Callback handler that will be called on success
	req.done(function (response) {

		// Grabs the return status from the returned JSON
		var returnStatus = $.evalJSON(response).returnStatus;

		// Grabs the error log from the returned JSON
		var errorLog = $.evalJSON(response).errorLog;

		if (returnStatus === "Customer Updated") {

			$(modalOutputName).removeClass().addClass( "alert alert-success" );
			$(modalOutputName).empty().append( "<strong>Successfully Updated "
				+ "Customer</strong>: The customer was successfully updated!" );

		}
		else if (returnStatus === "Customer Not Updated") {

			$(modalOutputName).removeClass().addClass( "alert alert-info" );
			$(modalOutputName).empty().append( "<strong>Customer Not Updated "
				+ "</strong>: The customer was not updated since none of their "
				+ "information for this customer was changed!" );

		}
		else if (returnStatus === "Connection Failed") {

			$(modalOutputName).removeClass().addClass( "alert alert-danger" );
			$(modalOutputName).empty().append( "<strong>Database Connection Failed"
				+ "</strong>: Unable to establish a connection to the database" );

		}
		else {

			$(modalOutputName).removeClass().addClass( "alert alert-danger" );
			$(modalOutputName).empty().append( "<strong>Unknown Error</strong>: "
				+ "An unknown error occurred!" );

		}

	});

}

function searchCustomer() {

	var serializedData = $("#searchForm").serialize();

	// Fire off the POST request to writeConfig.php
	var req = $.ajax({

		url: "../includes/findCustomer.php",
		type: "GET",
		data: serializedData

	});

	// Callback handler that will be called on success
	req.done(function (response, textStatus, jqXhr) {

		var returnStatus = $.evalJSON(response).returnStatus; // Grabs the return status from the returned JSON
		var errorLog = $.evalJSON(response).errorLog; // Grabs the error log from the returned JSON

		if (returnStatus === "Success") {

			var returnObject = $.evalJSON(response).returnObject; // Grabs the return object from the returned JSON
			var modalOutput = $.evalJSON(returnObject).modalOutput; // Grabs the modal output from the returned JSON
			var tableOutput = $.evalJSON(returnObject).tableOutput; // Grabs the table output from the returned JSON

			$("tbody#searchResults").empty().append(tableOutput);
			$("div#modalOutput").empty().append(modalOutput);

		}
		else if (returnStatus === "No results") {

			$("tbody#searchResults").empty().append("");
			$("div#modalOutput").empty().append("");

		}

	});

}

$(document).ready(function() {

	// Variable to hold current request
	var request;

	// Allows the ability to detect if the cancel button on the Add Customer form was clicked
	$("#addCustomerCancelButton").click(function () {

		$(this).addClass("e-clicked");

	});

	// Allows the ability to detect if the add button on the Add Customer form was clicked
	$("#addCustomerAddButton").click(function () {

		$(this).addClass("e-clicked");

	});

	// Bind to the submit event of the addCustomerForm form
	$("#addCustomerForm").submit(function (event) {

		// Abort any pending request
		if (request) {

			request.abort();

		}

		// setup some local variables
		var $form = $(this);

		// Let's select and cache all the fields
		var $inputs = $form.find("input, select, button, textarea");

		// Serialize the data in the form
		var serializedData = $form.serialize();

		// Let's disable the inputs for the duration of the Ajax request.
		// Note: we disable elements AFTER the form data has been serialized.
		// Disabled form elements will not be serialized.
		$inputs.prop("disabled", true);

		if ($(this).find(".e-clicked").attr("id") === "addCustomerCancelButton") {

			// Resets Add Customer Form to its default state
			$("#addCustomerForm").trigger("reset");

			// Removes the e-clicked class from the cancel button
			$("#addCustomerCancelButton").removeClass("e-clicked");

			// Reenable the inputs
			$inputs.prop("disabled", false);


		} else {

			if ($(this).find(".e-clicked").attr("id") === "addCustomerAddButton") {

				// Fire off the POST request to writeConfig.php
				request = $.ajax({

					url: "../includes/addCustomerToDB.php",
					type: "POST",
					data: serializedData

				});

				// Callback handler that will be called on success
				request.done(function (response, textStatus, jqXhr) {

					var returnStatus = $.evalJSON(response).returnStatus; // Grabs the return status from the returned JSON
					var errorLog = $.evalJSON(response).errorLog; // Grabs the error log from the returned JSON

					if (returnStatus === "Success") {

						// Tell the user that the customer was added successfully
						alert("Customer added successfully!");

						// Resets Add Customer Form to its default state
						$("#addCustomerForm").trigger("reset");

						// Removes the e-clicked class from the add button
						$("#addCustomerAddButton").removeClass("e-clicked");

					} else {

						if (returnStatus === "Duplicate Account Number") {

							// Tell the user that a customer with this account number already exists
							alert("A customer with this account number already exists!");

							// Removes the e-clicked class from the add button
							$("#addCustomerAddButton").removeClass("e-clicked");

						} else {

							// Tell the user that the record was unable to be added
							alert("Unable to add new customer!");

							// Removes the e-clicked class from the add button
							$("#addCustomerAddButton").removeClass("e-clicked");

						}

					}

				});

				// Callback handler that will be called on failure
				request.fail(function (jqXhr, textStatus, errorThrown) {

					// Log the error to the console
					console.error(
					   "The following error occurred: " +
						  textStatus, errorThrown
					);

				});

				// Callback handler that will be called regardless
				// if the request failed or succeeded
				request.always(function () {

					// Reenable the inputs
					$inputs.prop("disabled", false);

				});

			}

		}

		// Prevent default posting of form
		event.preventDefault();

	});

	// Bind to the submit event of the adminCreationForm form
	$("#adminCreationForm").submit(function (event) {

		// Abort any pending request
		if (request) {

			request.abort();

		}

		// setup some local variables
		var $form = $(this);

		// Let's select and cache all the fields
		var $inputs = $form.find("input, select, button, textarea");

		// Serialize the data in the form
		var serializedData = $form.serialize();

		serializedData += "&inputUserAccountNumber=000000000&inputIsAdmin=1";

		// Let's disable the inputs for the duration of the Ajax request.
		// Note: we disable elements AFTER the form data has been serialized.
		// Disabled form elements will not be serialized.
		$inputs.prop("disabled", true);

		// Fire off the POST request to writeConfig.php
		request = $.ajax({

			url: "includes/addUser.php",
			type: "POST",
			data: serializedData

		});

		// Callback handler that will be called on success
		request.done(function (response, textStatus, jqXhr) {

			// Refresh the page
			setTimeout(function () { window.location.reload(true); }, 5000);

		});

		// Callback handler that will be called on failure
		request.fail(function (jqXhr, textStatus, errorThrown) {

			// Log the error to the console
			console.error(
			   "The following error occurred: " +
				  textStatus, errorThrown
			);

		});

		// Callback handler that will be called regardless
		// if the request failed or succeeded
		request.always(function () {

			// Reenable the inputs
			$inputs.prop("disabled", false);

		});

		// Prevent default posting of form
		event.preventDefault();

	});

	// Bind to the submit event of the writeDatabaseConfigurationForm form
	$("#writeDatabaseConfigurationForm").submit(function (event) {

	  // Abort any pending request
	  if (request) {

		 request.abort();

	  }

	  // setup some local variables
	  var $form = $(this);

	  // Let's select and cache all the fields
	  var $inputs = $form.find("input, select, button, textarea");

	  // Serialize the data in the form
	  var serializedData = $form.serialize();

	  // Let's disable the inputs for the duration of the Ajax request.
	  // Note: we disable elements AFTER the form data has been serialized.
	  // Disabled form elements will not be serialized.
	  $inputs.prop("disabled", true);

	  // Fire off the POST request to writeConfig.php
	  request = $.ajax( {

		 url: "includes/writeConfig.php",
		 type: "POST",
		 data: serializedData

	  });

	  // Callback handler that will be called on success
	  request.done(function (response, textStatus, jqXhr) {

		 // Fire off a POST request to createTable.php
		 var createTableRequest = $.ajax( {

			url: "includes/createTable.php",
			type: "POST"

		 });

		 createTableRequest.done(function(response, textStatus, jqXhr) {

			$('#WriteDatabaseConfigurationForm').trigger("reset"); // Resets form1 to its default state
			$('div#returnOutput').text( "The database configuration was written successfully! This page will refresh in 5 seconds." );
			setTimeout(function () { window.location.reload(true); }, 5000);

		 });

		 createTableRequest.fail(function(jqXhr, textStatus, errorThrown) {

			// Log the error to the console
			console.error(
			   "The following error occurred: "+
				  textStatus, errorThrown
			);

		 });

		});

	  // Callback handler that will be called on failure
	  request.fail(function (jqXhr, textStatus, errorThrown) {

		 // Log the error to the console
		 console.error(
			"The following error occurred: "+
			   textStatus, errorThrown
		 );

	  });

	  // Callback handler that will be called regardless
	  // if the request failed or succeeded
	  request.always(function () {

		 // Reenable the inputs
		 $inputs.prop("disabled", false);

	  });

	  // Prevent default posting of form
	  event.preventDefault();

	});

	$(document.body).on("click", "#addFileButton", function(event) {

		// Some shiz here

	});

	// Bind to the submit event of the adminCreationForm form
	$(document.body).on("submit", "#loginForm", function(event) {

		// Abort any pending request
		if (request) {

			request.abort();

		}

		// setup some local variables
		var $form = $(this);

		// Let's select and cache all the fields
		var $inputs = $form.find("input, select, button, textarea");

		// Serialize the data in the form
		var serializedData = $form.serialize();

		// Let's disable the inputs for the duration of the Ajax request.
		// Note: we disable elements AFTER the form data has been serialized.
		// Disabled form elements will not be serialized.
		$inputs.prop("disabled", true);

		// Fire off the POST request to writeConfig.php
		request = $.ajax({

			url: "includes/loginUser.php",
			type: "GET",
			data: serializedData

		});

		// Callback handler that will be called on success
		request.done(function (response, textStatus, jqXhr) {

			var returnStatus = $.evalJSON(response).returnStatus; // Grabs the return status from the returned JSON
			var errorLog = $.evalJSON(response).errorLog; // Grabs the error log from the returned JSON

			if (returnStatus === "Success") {

				// Refresh the page
				setTimeout(function() { window.location.reload(true); }, 1);

			} else {

				if (returnStatus === "Fail User") {

					alert("Wrong email or password!");

				} else {

					// Refresh the page
					setTimeout(function () { window.location.reload(true); }, 1);

				}

			}

		});

		// Callback handler that will be called on failure
		request.fail(function (jqXhr, textStatus, errorThrown) {

			// Log the error to the console
			console.error(
			   "The following error occurred: " +
				  textStatus, errorThrown
			);

		});

		// Callback handler that will be called regardless
		// if the request failed or succeeded
		request.always(function () {

			// Reenable the inputs
			$inputs.prop("disabled", false);

		});

		// Prevent default posting of form
		event.preventDefault();

	});

	// Allow the login form to be submitted by a button outside of the form
	$(document.body).on("click", "#loginButton", function () {

		// Submit the loginForm
		$("#loginForm").submit();

	});

	// Bind to the submit event of the adminCreationForm form
	$(document.body).on("submit", "#registerForm", function (event) {

		// Abort any pending request
		if (request) {

			request.abort();

		}

		// setup some local variables
		var $form = $(this);

		// Let's select and cache all the fields
		var $inputs = $form.find("input, select, button, textarea");

		// Serialize the data in the form
		var serializedData = $form.serialize();

		// Append the fact that the user is not an admin
		serializedData += "&inputIsAdmin=0";

		// Let's disable the inputs for the duration of the Ajax request.
		// Note: we disable elements AFTER the form data has been serialized.
		// Disabled form elements will not be serialized.
		$inputs.prop("disabled", true);

		// Fire off the POST request to writeConfig.php
		request = $.ajax({

			url: "includes/addUser.php",
			type: "POST",
			data: serializedData

		});

		// Callback handler that will be called on success
		request.done(function (response, textStatus, jqXhr) {

			var returnStatus = $.evalJSON(response).returnStatus; // Grabs the return status from the returned JSON
			var errorLog = $.evalJSON(response).errorLog; // Grabs the error log from the returned JSON

			if (returnStatus === "Success") {

				alert("Registration successful!");

				// Refresh the page
				setTimeout(function () { window.location.reload(true); }, 1);

			} else {

				alert("Unable to register account");

			}

		});

		// Callback handler that will be called on failure
		request.fail(function (jqXhr, textStatus, errorThrown) {

			// Log the error to the console
			console.error(
			   "The following error occurred: " +
				  textStatus, errorThrown
			);

		});

		// Callback handler that will be called regardless
		// if the request failed or succeeded
		request.always(function () {

			// Reenable the inputs
			$inputs.prop("disabled", false);

		});

		// Prevent default posting of form
		event.preventDefault();

	});

	// Allow the registration form to be submitted by a button outside of the form
	$(document.body).on("click", "#registerButton", function () {

		// Submit the loginForm
		$("#registerForm").submit();

	});

	var password = document.querySelector(" input[name=inputAdminUserPass]");
	var passwordConfirm = document.querySelector(" input[name=inputAdminUserRepeat]");
	if (password && passwordConfirm) {
		[].forEach.call([password, passwordConfirm], function (el) {
			el.addEventListener("input", function () {
				if (el.validity.patternMismatch === false) {
					if (password.value === passwordConfirm.value) {
						try {
							password.setCustomValidity("");
							passwordConfirm.setCustomValidity("");

						}
						catch (e) { }
					}
					else {
						password.setCustomValidity("The two passwords do not match");
					}
				}
				if ((password.checkValidity() && passwordConfirm.checkValidity()) === false) {
					password.setCustomValidity("The two passwords do not match, and they don't comply with the password rules.");
					passwordConfirm.setCustomValidity("The two passwords do not match, and they don't comply with the password rules.");
				}
				else {
					password.setCustomValidity("");
					passwordConfirm.setCustomValidity("");

				}
			}, false);
		});
	}

});
