"use strict";

document.addEventListener("DOMContentLoaded", function () {
  var passwordInput = document.getElementById("password");
  var toggleButton = document.getElementById("show_pw");
  var toggleIcon = toggleButton.querySelector("i");
  toggleButton.addEventListener("click", function () {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggleIcon.classList.remove("fa-eye");
      toggleIcon.classList.add("fa-eye-slash");
    } else {
      passwordInput.type = "password";
      toggleIcon.classList.remove("fa-eye-slash");
      toggleIcon.classList.add("fa-eye");
    }
  });
});