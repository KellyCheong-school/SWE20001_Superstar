/* 
Filename: enhancements2.js
Target html: index.html
Purpose : Slideshow
Author: Jason Tan
Date written: 16/5/2023
*/

"use strict";

function init() {
  var slideIndex = 0;
  var slides = document.getElementsByClassName("slide");
  var dots = document.getElementsByClassName("dot");
  var intervalId; // Variable to hold the interval ID

  // Show the initial slide
  showSlide(slideIndex);

  function showSlide(index) {
    // Hide all slides
    for (var i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }

    // Remove active class from all dots
    for (var i = 0; i < dots.length; i++) {
      dots[i].classList.remove("active");
    }

    // Show the current slide and dot
    slides[index].style.display = "block";
    dots[index].classList.add("active");
  }

  // Function to change slide
  function changeSlide() {
    slideIndex++;
    if (slideIndex >= slides.length) {
      slideIndex = 0;
    }
    showSlide(slideIndex);
  }

  // Automatically change slide every 5 seconds
  intervalId = setInterval(changeSlide, 5000);

  // Event listener for dots
  for (var i = 0; i < dots.length; i++) {
    dots[i].addEventListener("click", function (event) {
      var clickedDot = event.target;
      var dotIndex = Array.prototype.indexOf.call(dots, clickedDot);
      slideIndex = dotIndex;
      showSlide(slideIndex);
      
      // Reset the interval timer when dot is clicked
      clearInterval(intervalId);
      intervalId = setInterval(changeSlide, 5000);
    });
  }
}

// Call the init function when the window loads
window.onload = init;