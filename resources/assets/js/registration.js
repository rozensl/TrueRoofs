// function to validate the sign in form using the helper functions
function validateSignIn(form) {
	// get the form elements 
	var username = document.getElementById('username');
	var passcode = document.getElementById('password');
	var email = document.getElementById('email');
	var check = true;
	// validate username
	if (!(validateUsername(username))) {
		alert("Username must be alphanumerical and at least 6 characters.");
		username.focus();
		return false;
	}
	// validate email
	else if (!(validateEmail(email))) {
		alert("Email is invalid! Please enter a valid email address.");
		email.focus();
		return false;
	}
	// validate password
	else if (!(validatePassword(passcode))) {
		alert("Password must contain at least one numerical, uppercase, and lowercase character.")
		passcode.focus();
		return false;
	}
	// validate looking for 
	else if (!form.buying.checked && !form.browsing.checked && !form.renting.checked ) {
		alert("Please select reason for joining True Roofs.")
		return false;
	}
	// form is fully validated
	else {
		return true;
	}
}

// function to validate the log in form using the helper functions
function validateLogIn(form) {
	// get the form elements
	var username = document.getElementById('username');
	var passcode = document.getElementById('password');
	// validate username
	if (!(validateUsername(username))) {
		alert("Username must be alphanumerical and at least 6 characters.");
		username.focus();
		return false;
	}
	// validate password
	else if (!(validatePassword(passcode))) {
		alert("Password must contain at least one numerical, uppercase, and lowercase character.")
		passcode.focus();
		return false;
	}
	// form is fully validated
	return true;
}

// helper function to check the username format
function validateUsername(username) {
	var reg = /^[0-9a-zA-Z]{6,}$/; // alphanumerical string
	// make sure username contains both letters and numbers
	if (!reg.test(username.value)) {
		return false;
	}
	// return true if username is fully validated
	return true;
}

// helper function to check the email format
function validateEmail(email) {
	var reg = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/ // email that does not start with @ and contains only one @ and with . and ends with at least 2 letters
	
	// make sure it is formated as example@platform.com 
	if (!reg.test(email.value)) {
		return false;
	}
	// return true if email is fully validated
	return true;
}

// helper function to check the password format
function validatePassword(passcode) {
	var reg = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/; // password with at least one number, one uppercase, and one lower case

	//check the reg exp is satsified 
	if (!reg.test(passcode.value)) {
		return false;
	}
	// return true if password is fully validated 
	return true;
}

// helper function to check the interest field 
function validateLooking(form) {
	if (!form.buying.checked || !form.browsing.checked || !form.renting.checked ) {
		alert("Please select reason for joining True Roofs.")
		return false;
	}
}