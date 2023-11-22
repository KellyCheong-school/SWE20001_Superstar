/* 
Filename: enhancements.js
Target html: enquire.html
Purpose : Date validation
Author: Jason Tan
Date written: 11/5/2023
*/

"use strict";

// Function to validate the calendar
function calendar() {
  // Get current date in UTC+8 timezone
  const now = new Date();
  const utcOffset = now.getTimezoneOffset() * 60000;
  const currentDate = new Date(now.getTime() + (utcOffset + 8 * 60 * 60 * 1000));

  // Set departure date input to today's date in UTC+8 timezone
  const departureDateInput = document.getElementById("departureDate");
  departureDateInput.valueAsDate = currentDate;

  // Set minimum and maximum dates for departure date input

  /*toISOString().split("T")[0], is used to get only the date portion of the ISO 
  string (for example: "YYYY-MM-DDT10:30:00.000Z") by taking the first element of 
  the array returned by the split("T") method*/
  const minDepartureDate = currentDate.toISOString().split("T")[0];
  // Calculate the maximum date which is 2 years to the current date and get the date portion of the ISO string
  const maxDepartureDate = new Date(currentDate.getTime() + (2 * 365 * 24 * 60 * 60 * 1000)).toISOString().split("T")[0];
  departureDateInput.setAttribute("min", minDepartureDate);
  departureDateInput.setAttribute("max", maxDepartureDate);

  // Add event listener to departure date input to update return date input
  const returnDateInput = document.getElementById("returnDate");
  // Disable the selection of return date until depature date is selected
  returnDateInput.disabled = true;
  departureDateInput.addEventListener("change", () => {
    const selectedDepartureDate = new Date(departureDateInput.value);
    const minReturnDate = selectedDepartureDate.toISOString().split("T")[0];
    const maxReturnDate = new Date(selectedDepartureDate.getTime() + (2 * 365 * 24 * 60 * 60 * 1000)).toISOString().split("T")[0];
    returnDateInput.setAttribute("min", minReturnDate);
    returnDateInput.setAttribute("max", maxReturnDate);
    // Reenable the selection of return date
    returnDateInput.disabled = false;
    if (returnDateInput.valueAsDate < selectedDepartureDate) {
      returnDateInput.valueAsDate = selectedDepartureDate;
    }
  });
}

/* check if session data on user exists and if so prefill the form */
function prefillForm(){
	if (sessionStorage.firstname != undefined){		// check if storage for username is not empty
      
        // Prefill form fields with session data
        document.getElementById("firstname").value = sessionStorage.getItem("firstname");
        document.getElementById("lastname").value = sessionStorage.getItem("lastname");
        document.getElementById("email").value = sessionStorage.getItem("email");
        document.getElementById("phone").value = sessionStorage.getItem("phone");
        document.getElementById("street").value = sessionStorage.getItem("street");
        document.getElementById("suburb").value = sessionStorage.getItem("suburb");
        document.getElementById("state").value = sessionStorage.getItem("state");
        document.getElementById("postcode").value = sessionStorage.getItem("postcode");
	
        // Set the appropriate contact method based on session data
        switch (sessionStorage.contacts){
            case "Email":
                document.getElementById("email_contact").checked = true;
                break;
            case "Post":
                document.getElementById("post_contact").checked = true;
                break;
            case "Phone":
                document.getElementById("phone_contact").checked = true;
                break;
        }

        // Continue prefill additional form fields with session data
        document.getElementById("departureDate").value = sessionStorage.getItem("departureDate");
        document.getElementById("returnDate").value = sessionStorage.getItem("returnDate");
        document.getElementById("flight").value = sessionStorage.getItem("flight");
        document.getElementById("cabin").value = sessionStorage.getItem("cabin");
        document.getElementById("features").value = sessionStorage.features;

        // Check the checkboxes for selected optional features based on session data
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const optionalFeatures = sessionStorage.features.split(', ');
        checkboxes.forEach(checkbox => {
            if (optionalFeatures.includes(checkbox.value)) {
            checkbox.checked = true;
            }
        });

        document.getElementById("numTickets").value = sessionStorage.getItem("numTickets");
        document.getElementById("comment").value = sessionStorage.getItem("comment");
	}
}

function init() {

  // Call the function to initialize the calendar functionality
  calendar();

  var debug = true;

    // Call the function to prefill the form with session data
  if (!debug) {
    prefillForm();
  } 
  
}

// Add an event listener to wait for the DOMContentLoaded event,
// which indicates that the initial HTML document has been completely loaded and parsed
window.addEventListener("DOMContentLoaded", init);