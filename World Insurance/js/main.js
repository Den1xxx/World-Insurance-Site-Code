/* Main JavaScript functions for the site
 * If it ain't here, it ain't nowhere ;)
 *
 * Author: techsym
 * Maintainer: techsym
 * Version: 0.0.1
 * Version Date: 01/18/2015
 *
 */
 
$(document).ready(function() {
   
    // Variable to hold current request
    var request;
   
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
                
                alert("Wrong email or password!");

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

    $(document.body).on("click", "#loginButton", function () {

        // Submit the loginForm
        $("#loginForm").submit();

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
