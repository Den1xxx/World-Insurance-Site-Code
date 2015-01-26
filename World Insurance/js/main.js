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
   
   // Bind to the submit event of our form
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
         
      } );
      
      // Callback handler that will be called on success
      request.done(function (response, textStatus, jqXhr) {
         
         // Fire off a POST request to createTable.php
         var createTableRequest = $.ajax( {
            
            url: "includes/createTable.php",
            type: "POST"
            
         } );
         
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
         
	    } );
      
      // Callback handler that will be called on failure
      request.fail(function (jqXhr, textStatus, errorThrown) {
         
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
   
   //$("[name=\"loginRegisterSwitch\"]").bootstrapSwitch();

   // Bind to the radio buttons in registration/login form and change "submit" button as needed
   /*$("input[name=\"loginRegisterSwitch\"]").change(function () {
      
      var registerLoginValue = $(this).val();
      if (registerLoginValue == "login") {
         
         document.getElementById("passwordInput2").style.display = "none";
         document.getElementById("registerButton").style.display = "none";
         document.getElementById("loginButton").style.display = "block";
         
      }
      else if (registerLoginValue == "register") {
         
         document.getElementById("loginButton").style.display = "none";
         document.getElementById("passwordInput2").style.display = "block";
         document.getElementById("registerButton").style.display = "block";
         
      }
        
   } );*/
   
} );
