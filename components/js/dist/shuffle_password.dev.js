"use strict";

document.getElementById("shuffle_pw").addEventListener("click", function () {
  function generateRandomPassword(length) {
    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=";
    var password = "";

    for (var i = 0; i < length; i++) {
      var randomIndex = Math.floor(Math.random() * charset.length);
      password += charset[randomIndex];
    }

    return password;
  }

  var randomPassword = generateRandomPassword(12);
  document.getElementById("password").value = randomPassword;
});