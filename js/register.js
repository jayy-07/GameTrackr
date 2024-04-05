function validateForm() {
  var password = document.getElementById("password").value;
  var confirmPassword = document.getElementById("confirm-password").value;
  if (password != confirmPassword) {
    document.getElementById("error-message").innerHTML =
      "Passwords do not match";
    event.preventDefault();
    return false;
  }
  return true;
}
