/* 
Filename: part2.js
Target html: enquire.html
Purpose : validate input
Author: Jason Tan
Date written: 10/5/2023
*/

"use strict";

// Validate the combination of state and postcode
function validateStatePostcode(state, postcode) {
    const postcodeFirstDigit = postcode.substr(0, 1);
    switch (state) {
      case "VIC":
        return postcodeFirstDigit === "3" || postcodeFirstDigit === "8";
      case "NSW":
        return postcodeFirstDigit === "1" || postcodeFirstDigit === "2";
      case "QLD":
        return postcodeFirstDigit === "4" || postcodeFirstDigit === "9";
      case "NT":
        return postcodeFirstDigit === "0";
      case "WA":
        return postcodeFirstDigit === "6";
      case "SA":
        return postcodeFirstDigit === "5";
      case "TAS":
        return postcodeFirstDigit === "7";
      case "ACT":
        return postcodeFirstDigit === "0";
    }
}

/*get variables from form and check rules*/
function validate(){
    // Initialize local variables
    var errMsg = "";                    // Stores the error message
    var isValid = true;                 // Assumes no errors

    // Validate the form inputs and get the values of the form inputs
    const firstname = document.getElementById("firstname").value.trim();
    if (!firstname.match(/^[a-zA-Z]+$/) || firstname.length > 25) {
        errMsg += "Please enter a valid first name.\n";
        isValid = false;
    }

    const lastname = document.getElementById("lastname").value.trim();
    if (!lastname.match(/^[a-zA-Z]+$/) || lastname.length > 25) {
        errMsg += "Please enter a valid last name.\n";
        isValid = false;
    }

    const email = document.getElementById("email").value.trim();
    if (email === "") {
        errMsg += "Please enter a valid email address.\n";
        isValid = false;
    }

    const phone = document.getElementById("phone").value.trim();
    if (!phone.match(/^\d{0,10}$/)) {
        errMsg += "Please enter a valid phone number.\n";
        isValid = false;
    }

    const street = document.getElementById("street").value.trim();
    if (street === "" || street.length > 40) {
        errMsg += "Please enter a valid street address.\n";
        isValid = false;
    }

    const suburb = document.getElementById("suburb").value.trim();
    if (suburb === "" || suburb.length > 20) {
        errMsg += "Please enter a valid suburb/town.\n";
        isValid = false;
    }

    const state = document.getElementById("state").value.trim();
    if (state === "") {
        errMsg += "Please select a state.\n";
        isValid = false;
    }

    const postcode = document.getElementById("postcode").value.trim();
    if (!postcode.match(/^\d{4}$/) || postcode.length > 10) {
        errMsg += "Please enter a valid postcode.\n";
        isValid = false;        
    }

    const postcodeCheck = validateStatePostcode(state, postcode);
    if (!postcodeCheck) {
        errMsg += "The postcode does not match the selected state.\n";
        isValid = false;
    }

    const isEmail = document.getElementById("email_contact").checked;
    const isPost = document.getElementById("post_contact").checked;
    const isPhone = document.getElementById("phone_contact").checked;
    /*At least one preferred contact selected*/
    if (!(isEmail || isPost || isPhone)){
        errMsg += "Please select a contact method\n";
        isValid = false;
    }

    const departureDate = document.getElementById("departureDate").value.trim();
    if (departureDate === "") {
        errMsg += "Please select a departure date.\n";
        isValid = false;
    }

    const returnDate = document.getElementById("returnDate").value.trim();
    if (returnDate === "") {
        errMsg += "Please select a return date.\n";
        isValid = false;
    }

    const flight = document.getElementById("flight").value.trim();
    if (flight === "") {
        errMsg += "Please select a flight.\n";
        isValid = false;
    }

    const cabin = document.getElementById("cabin").value.trim();
    if (cabin === "") {
        errMsg += "Please select a cabin class.\n";
        isValid = false;
    }

    const isGourmetDining = document.getElementById("gourmet-dining").checked;
    const isPremiumEntertainment = document.getElementById("premium-entertainment").checked;

    const numTickets = document.getElementById("numTickets").value.trim();
    if (numTickets === "") {
        errMsg += "Please enter a valid number of tickets.\n";
        isValid = false;
    }

    const comment = document.getElementById("comment").value.trim();

    if (errMsg != ""){   // Only display message box if there is something to show
        alert(errMsg);
    }

    // If the form is valid, submit it
    if (isValid){        
        // store the values in the function
        storeBooking(firstname, lastname, email, phone, street, suburb, state, postcode, isEmail, isPost, isPhone, departureDate, returnDate, flight, cabin, isGourmetDining, isPremiumEntertainment, numTickets, comment);
    }

    return isValid;      // If false, the information will not be sent to the server
}

function storeBooking(firstname, lastname, email, phone, street, suburb, state, postcode, isEmail, isPost, isPhone, departureDate, returnDate, flight, cabin, isGourmetDining, isPremiumEntertainment, numTickets, comment){
    // get values and assign them to a sessionStorage attribute.
    // we use the same name for the attribute and the element id to avoid confusion
    
    // Store selected optional features in an array
    var contacts = [];
    if (isEmail) contacts.push("Email");
    if (isPost) contacts.push("Post");
    if (isPhone) contacts.push("Phone");

    var features = [];
    if (isGourmetDining) features.push("Gourmet Dining");
    if (isPremiumEntertainment) features.push("Premium Entertainment");

    // Join the trips array into a string using a separator
    var contactsStr = contacts.join(", ");
    var featuresStr = features.join(", ");

    // Store all values in sessionStorage
    // Store form input values in sessionStorage
    sessionStorage.firstname = firstname;
    sessionStorage.lastname = lastname;
    sessionStorage.email = email;
    sessionStorage.phone = phone;
    sessionStorage.street = street;
    sessionStorage.suburb = suburb;
    sessionStorage.state = state;
    sessionStorage.postcode = postcode;
    sessionStorage.contacts = contactsStr;
    sessionStorage.departureDate = departureDate;
    sessionStorage.returnDate = returnDate;
    sessionStorage.flight = flight;
    sessionStorage.cabin = cabin;
    sessionStorage.features = featuresStr;
    sessionStorage.numTickets = numTickets;
    sessionStorage.comment = comment;
}

function init() {
    const firstname = document.getElementById("firstname").value.trim();
    const lastname = document.getElementById("lastname").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const street = document.getElementById("street").value.trim();
    const suburb = document.getElementById("suburb").value.trim();
    const state = document.getElementById("state").value.trim();
    const postcode = document.getElementById("postcode").value.trim();
    const isEmail = document.getElementById("email_contact").checked;
    const isPost = document.getElementById("post_contact").checked;
    const isPhone = document.getElementById("phone_contact").checked;
    const departureDate = document.getElementById("departureDate").value.trim();
    const returnDate = document.getElementById("returnDate").value.trim();
    const flight = document.getElementById("flight").value.trim();
    const cabin = document.getElementById("cabin").value.trim();
    const isGourmetDining = document.getElementById("gourmet-dining").checked;
    const isPremiumEntertainment = document.getElementById("premium-entertainment").checked;
    const numTickets = document.getElementById("numTickets").value.trim();
    const comment = document.getElementById("comment").value.trim();

    var debug = true;

    // Assign the validate function to the submit event of the enquireForm
    var enquireForm = document.getElementById("enquireForm");

    if (!debug) {
        enquireForm.onsubmit = validate;
    } 

    enquireForm.onsubmit = storeBooking(firstname, lastname, email, phone, street, suburb, state, postcode, isEmail, isPost, isPhone, departureDate, returnDate, flight, cabin, isGourmetDining, isPremiumEntertainment, numTickets, comment);

}

// Call the init function when the window loads
window.onload = init;