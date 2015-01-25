jQuery(document).ready(function($) {

	// Variable to hold request
	var request;

	// Shows the Find Customer Form by default
	$("#FindCustomerForm").show();

	// Allows the ability to detect which submit button was clicked
	$("#submitDelete").click(function(e) {

		$(this).addClass("e-clicked");

	} );

	// Allows the ability to detect which submit button was clicked
	$("#submitUpdate").click(function(e) {

		$(this).addClass("e-clicked");

	} );

	// Bind to the submit event of our form
	$("#FindCustomerForm").submit(function(event) {

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

	    // Fire off the GET request to formLookupCustomer.php
	    request = $.ajax( {
	        url: "/worldins/wp-content/plugins/CustomerManagement/formFindCustomer.php",
	        type: "GET",
	        data: serializedData
	    } );

	    // Callback handler that will be called on success
	    request.done(function (response, textStatus, jqXHR) {

				$('#FindCustomerForm').hide();
				$('#FindCustomerForm').trigger("reset"); // Resets form1 to its default state

				var accountNumber = $.evalJSON(response).accountNumber; // Grabs the account number from the returned JSON
				var firstName = $.evalJSON(response).firstName; // Grabs the first name from the returned JSON
				var lastName = $.evalJSON(response).lastName; // Grabs the first name from the returned JSON
				var zip = $.evalJSON(response).zip; // Grabs the zip from the returned JSON

				if (firstName != null) {

					$('#UpdateCustomerForm').show(); // Show form3
					$('#accountNumber2').val(accountNumber); // Sets the account number in form3 as the returned account number
					$('#accountNumber2').prop("disabled", true);
					$('#firstName2').val(firstName); // Sets the account number in form3 as the returned account number
					$('#lastName2').val(lastName); // Sets the account number in form3 as the returned account number
					$('#zip2').val(zip); // Sets the account number in form3 as the returned account number

				}
				else {

					$('#FindCustomerForm').show(); // Show form1
					$('#accountNumber').val(accountNumber); // Sets the account number in form3 as the returned account number
					$('div#output').text("A customer with this account number: " + accountNumber + " does not exist!");

				}

	    } );

	    // Callback handler that will be called on failure
	    request.fail(function (jqXHR, textStatus, errorThrown) {
	        // Log the error to the console
	        console.error(
	            "The following error occurred: "+
	            textStatus, errorThrown
	        );
	    } );

	    // Callback handler that will be called regardless
	    // if the request failed or succeeded
	    request.always(function () {
	        // Reenable the inputs
	        $inputs.prop("disabled", false);
	    } );

	    // Prevent default posting of form
	    event.preventDefault();
	} );

	// Bind to the submit event of our AddCustomerForm
	$("#AddCustomerForm").submit(function(event) {

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

	    // Fire off the request to formAddCustomer.php
	    request = $.ajax( {
	        url: "/worldins/wp-content/plugins/CustomerManagement/formAddCustomer.php",
	        type: "POST",
	        data: serializedData
	    } );

	    // Callback handler that will be called on success
	    request.done(function (response, textStatus, jqXHR) {
			  $('#AddCustomerForm').trigger("reset"); // Resets form2 to its default state

			  if (response == true) {

				  $('div#errorOutput').text(
				   "The customer was added successfully!");

			  }
			  else {

				  $('div#errorOutput').text(
				    "There was an issue adding the customer!");

			}


	    } );

	    // Callback handler that will be called on failure
	    request.fail(function (jqXHR, textStatus, errorThrown) {
	        // Log the error to the console
	        console.error(
	            "The following error occurred: "+
	            textStatus, errorThrown
	        );
	    } );

	    // Callback handler that will be called regardless
	    // if the request failed or succeeded
	    request.always(function () {
	        // Reenable the inputs
	        $inputs.prop("disabled", false);
	    } );

	    // Prevent default posting of form
	    event.preventDefault();
	} );

	// Bind to the submit event of our AddCustomerForm
	$("#UpdateCustomerForm").submit(function(event) {

		// Abort any pending request
		if (request) {
			request.abort();
		}
		// setup some local variables
		var $form = $(this);

		// Momentarily enable the accountNumber2 field in order to capture its data
		$('#accountNumber2').prop("disabled", false);

		// Let's select and cache all the fields
		var $inputs = $form.find("input, select, button, textarea");

		// Serialize the data in the form
		var serializedData = $form.serialize();

		// Creates a variable that will hold the output text
		var output;

		// Creates a variable that will hold the account number
		var accountNumber = document.getElementById('accountNumber2').value;

		// Let's disable the inputs for the duration of the Ajax request.
		// Note: we disable elements AFTER the form data has been serialized.
		// Disabled form elements will not be serialized.
		$inputs.prop("disabled", true);

		if ( $(this).find('.e-clicked').attr('id') === 'submitCancel' ) {

			// Do Nothing :)

		}
		else if( $(this).find('.e-clicked').attr('id') === 'submitDelete' ) {

			var confirm = window.confirm(
				"Are you sure you want to delete this customer?" );

			if( !confirm ) {

				event.preventDefault();

			}
			else {

				// Fire off the request to formDeleteCustomer.php
				request = $.ajax( {
					url: "/worldins/wp-content/plugins/CustomerManagement/formDeleteCustomer.php",
					type: "POST",
					data: serializedData
				} );

				// Callback handler that will be called on success
				request.done(function (response, textStatus, jqXHR) {

					$('#UpdateCustomerForm').trigger("reset"); // Resets form2 to its default state

					if (response == true) {

						output = "The customer was deleted successfully!";

						}
						else {

							output = "There was an issue deleting the customer!";

						}

				} );

			}

		}
		else if ( $(this).find('.e-clicked').attr('id') === 'submitUpdate' ) {

			var confirm = window.confirm(
				"Are you sure you want to update this customer?" );

				if( !confirm ) {

					event.preventDefault();

				}
				else {

					// Fire off the request to formDeleteCustomer.php
					request = $.ajax( {
						url: "/worldins/wp-content/plugins/CustomerManagement/formUpdateCustomer.php",
						type: "POST",
						data: serializedData
					} );

					// Callback handler that will be called on success
					request.done(function (response, textStatus, jqXHR) {

						$('#UpdateCustomerForm').trigger("reset"); // Resets form2 to its default state

						if (response == true) {

							output = "The customer was updated successfully!";

						}
						else {

							output = "There were no changes, the customer was not updated!";

						}

					} );

				}

		}

		// Callback handler that will be called on failure
		request.fail(function (jqXHR, textStatus, errorThrown) {
			// Log the error to the console
			console.error(
				"The following error occurred: "+
				textStatus, errorThrown
			);
		} );

		// Callback handler that will be called regardless
		// if the request failed or succeeded
		request.always(function () {

			// Reenable the inputs
			$inputs.prop("disabled", false);

			// Hide Update Customer Form
			$("#UpdateCustomerForm").hide();

			// Show Find Customer Form
			$("#FindCustomerForm").show();

			// Sets the account number in the accountNumber field
			$('#accountNumber').val(accountNumber); // Sets the account number in form3 as the returned account number

			// Display output
			$('div#output').text( output );

		} );

		// Reset classes on all the submit buttons in this form
		$( this ).find( "input[ type = 'submit' ]" ).removeClass( "e-clicked" );

		// Prevent default posting of form
		event.preventDefault();

	} );

	function closeAccordionSection() {

		$('.accordion .accordion-section-title').removeClass('active');
		$('.accordion .accordion-section-content').slideUp(300).removeClass('open');

	}

	$('.accordion-section-title').click(function(e) {

		// Grab current anchor value
		var currentAttrValue = $(this).attr('href');

		if($(e.target).is('.active')) {

			closeAccordionSection();

		}
		else {

			closeAccordionSection();

			// Add active class to section title
			$(this).addClass('active');

			// Open up the hidden content panel
			$('.accordion ' + currentAttrValue).slideDown(300).addClass('open');

		}

		e.preventDefault();

	} );

} );
