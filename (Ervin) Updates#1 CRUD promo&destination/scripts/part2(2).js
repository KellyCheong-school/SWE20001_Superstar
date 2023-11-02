/* 
Filename: part2(2).js
Target html: payment.html
Purpose : Load data from session storage and submit to server
Author: Jason Tan
Date written: 14/5/2023
*/

"use strict";

// Function to validate credit card number based on card type
function isValidCreditCardNumber(cardNumber, cardType) {
    if (cardType === "Visa") {
      return cardNumber.match(/^4\d{15}$/);
    } 
    else if (cardType === "Mastercard") {
      return cardNumber.match(/^5[1-5]\d{14}$/);
    } 
    else if (cardType === "AmEx") {
      return cardNumber.match(/^3[47]\d{13}$/);
    }
    return false;
}
  
// Function to validate expiry date
function isValidExpiryDate(expiryDate) {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    currentYear = currentYear % 100;
    var currentMonth = currentDate.getMonth() + 1; // Month is zero-based

    var parts = expiryDate.split("-");
    var month = parseInt(parts[0]);
    var year = parseInt(parts[1]);

    if (year < currentYear || (year === currentYear && month < currentMonth)) {
        return false;
    }

    return expiryDate.match(/^(0[1-9]|1[0-2])-\d{2}$/);
}

// Function to validate form
function validate(){
	
	var errMsg = "";								/* stores the error message */
	var isValid = true;								/* assumes no errors */

    // Get the input values
    var cardType = document.getElementById("cardType").value;
    var cardName = document.getElementById("cardName").value;
    var cardNumber = document.getElementById("cardNumber").value;
    var expiryDate = document.getElementById("expiryDate").value;
    var cvv = document.getElementById("cvv").value;
    
    // Validate credit card type
    if (cardType === "") {
        errMsg += "Please select a valid credit card type.\n";
        isValid = false;
    }
    
    // Validate name on credit card
    if (!cardName.match(/^[A-Za-z\s]{1,40}$/)) {
        errMsg += "Please enter a valid name on credit card (maximum 40 characters, alphabetical and space only).\n";
        isValid = false;
    }
    
    // Validate credit card number
    if (!isValidCreditCardNumber(cardNumber, cardType)) {
        errMsg += "Please enter a valid credit card number.\n";
        isValid = false;
    }
    
    // Validate expiry date
    if (!isValidExpiryDate(expiryDate)) {
        errMsg += "Please enter a valid expiry date (mm-yy).\n";
        isValid = false;
    }
    
    // Validate CVV
    if (!cvv.match(/^\d{3,4}$/)) {
        errMsg += "Please enter a valid card verification value (CVV).\n";
        isValid = false;
    }

    if (errMsg != ""){   // Only display message box if there is something to show
        alert(errMsg);
    }

	return isValid;    //if false, the information will not be sent to the server
}

function formatDate(dateString) {
    const [year, month, day] = dateString.split("-");       // Split the date string into year, month, and day
    return `${day}-${month}-${year}`;                       // Format the date as day-month-year
}  

function calculateFlight(flight, cabin, features, numTickets) {
    // Calculate the total price of the purchase
    var flightPrice = 0;
    if (flight === "Tokyo, Japan") {
        flightPrice = 2000;
    }
    else if(flight === "Bali, Indonesia"){
        flightPrice = 500;
    }
    else if(flight === "Singapore"){
        flightPrice = 300;
    }       
    
    var pricePerTicket = 0;
    if (cabin === "First Class") {
        pricePerTicket = 500;
    } 
    else if (cabin === "Business Class") {
        pricePerTicket = 250;
    } 
    else if (cabin === "Economy Class"){
        pricePerTicket = 0;
    }
    
    var totalFeaturesPrice = 0;
    // Split the features string into an array of optional features
    const optionalFeatures = features.split(', ');
    for (var i = 0; i < optionalFeatures.length; i++) {
        if (optionalFeatures[i] === "Gourmet Dining") {
            totalFeaturesPrice += 100;
        }
        else if (optionalFeatures[i] === "Premium Entertainment") {
            totalFeaturesPrice += 50;
        }
    }
    
    // Calculate the total price by multiplying the number of tickets with the sum of prices
    const totalPrice = numTickets * (pricePerTicket + flightPrice + totalFeaturesPrice);

    // Display the total price on the payment page
    return totalPrice.toFixed(2);       // Convert the total price to a fixed 2 decimal places
}

// Function to pass value from session storage to the fields
function getBooking(){
    if(sessionStorage.firstname != undefined){    //if sessionStorage for username is not empty

        // Display the values on the payment page
        document.getElementById("firstname").textContent = sessionStorage.firstname;
        document.getElementById("lastname").textContent = sessionStorage.lastname;
        document.getElementById("email").textContent = sessionStorage.email;
        document.getElementById("phone").textContent = sessionStorage.phone;
        document.getElementById("address").textContent = sessionStorage.street + ", " + sessionStorage.suburb;
        document.getElementById("contacts").textContent = sessionStorage.contacts;
        document.getElementById("state").textContent = sessionStorage.state;
        document.getElementById("postcode").textContent = sessionStorage.postcode;
        document.getElementById("departureDate").textContent = formatDate(sessionStorage.departureDate);
        document.getElementById("returnDate").textContent = formatDate(sessionStorage.returnDate);
        document.getElementById("flight").textContent = sessionStorage.flight;
        document.getElementById("cabin").textContent = sessionStorage.cabin;
        document.getElementById("features").textContent = sessionStorage.features;
        document.getElementById("numTickets").textContent = sessionStorage.numTickets;
        document.getElementById("comment").textContent = sessionStorage.comment;
        const totalPrice = calculateFlight(sessionStorage.flight, sessionStorage.cabin, sessionStorage.features, sessionStorage.numTickets)
        document.getElementById("totalPrice").textContent  = totalPrice;

        // Populate input fields
        document.getElementById('Firstname').value = sessionStorage.firstname;
        document.getElementById('Lastname').value = sessionStorage.lastname;
        document.getElementById('Email').value = sessionStorage.email;
        document.getElementById('Phone').value = sessionStorage.phone;
        document.getElementById('Street').value = sessionStorage.street;
        document.getElementById('Suburb').value = sessionStorage.suburb;
        document.getElementById('Contacts').value = sessionStorage.contacts;
        document.getElementById("State").value = sessionStorage.state;
        document.getElementById("Postcode").value = sessionStorage.postcode;
        document.getElementById('DepartureDate').value = formatDate(sessionStorage.departureDate);
        document.getElementById('ReturnDate').value = formatDate(sessionStorage.returnDate);
        document.getElementById('Flight').value = sessionStorage.flight;
        document.getElementById('Cabin').value = sessionStorage.cabin;
        document.getElementById('Features').value = sessionStorage.features;
        document.getElementById('NumTickets').value = sessionStorage.numTickets;
        document.getElementById('Comment').value = sessionStorage.comment;
        document.getElementById('TotalPrice').value = totalPrice;
    }
}

function backToForm(){
    // Redirect the user back to the enquire.php page
	window.location = "enquire.php";
}

function cancelBooking(){
    sessionStorage.clear();        // Clear all stored session data
	window.location = "index.php"; // Redirect the user back to the index.php page
}

function init () {
    var debug = true;

    var back = document.getElementById("backForm");
    // Assign the backToForm function to the click event of the back button
	back.onclick = backToForm;	

    var cancel = document.getElementById("cancelButton");
    // Assign the cancelBooking function to the click event of the cancel button
	cancel.onclick = cancelBooking;	

	var bookForm = document.getElementById("bookform");		// link the variable to the HTML element
    // Assign the validate function to the submit event of the bookForm
	if (!debug){
        bookForm.onsubmit = validate;
    }
    
 }

// Call the init function when the window loads
window.onload = init;