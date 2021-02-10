/* Javascript Functions */
	
// Check registration fields for submission
function checkRegistration(form, email, password, confirmPassword) {
	
	// Check if any fields are empty
    if (email.value == '' || password.value == '' || confirmPassword.value == '') {
		new Messi("You must provide all the requested details. Please try again.", {title: 'Error', modal: true, width: 'auto'});
        return false;
    }
	
	// Check if email is valid
	var atpos = email.value.indexOf("@");
	var dotpos = email.value.lastIndexOf(".");
	if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.value.length) {
	  new Messi("Please enter a valid email address.", {title: 'Error', modal: true, width: 'auto'});
	  return false;
	}
	
	// Check if password is at least 6 characters long
    if (password.value.length < 6) {
		new Messi("Passwords must be at least 6 characters long. Please try again.", {title: 'Error', modal: true, width: 'auto'});
        form.password.focus();
        return false;
    }
 
    // RegEx Test: Password must have at least one uppercase, one lowercase, and one number
    var regEx = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!regEx.test(password.value)) {
		new Messi("Passwords must contain at least one uppercase letter, one lowercase letter, and one number.", 
			{title: 'Error', modal: true, width: 'auto'});
        return false;
    }
 
    // Check password and confirmation are the same
    if (password.value != confirmPassword.value) {
		new Messi("Your password and confirmation do not match. Please try again.", {title: 'Error', modal: true, width: 'auto'});
        form.password.focus();
        return false;
    }
 
    // Create hashed password field 
    var p = document.createElement("input");
 
    // Add the new element to form
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Clear plain text passwords before submission 
    password.value = "";
    confirmPassword.value = "";
 
    // Submit the form
    form.submit();
    return true;
}

// Make sure first name and last name fields are not blank
function checkFields(form, firstname, lastname) {
	if (firstname.value == '' || lastname.value == '') {
		new Messi("Please provide a first and last name.", {title: 'Error', modal: true, width: 'auto'});
		return false;
	} else {
		form.submit();
		return true;
	}
}

// Create hash for submitted sign-in password
function createHash(form, password) {
	
	// Create hashed password field
	var p = document.createElement("input");
 
	// Add the new element to form
	form.appendChild(p);
	p.name = "p";
	p.type = "hidden";
	p.value = hex_sha512(password.value);
	
	// Clear plain text passwords before submission 
	password.value = "";
	
	// Submit the form
	form.submit();
}

function base64_encode(data) {
	var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
	var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
	ac = 0,
	enc = '',
	tmp_arr = [];
	
	if (!data) {
		return data;
	}
	
	do { // pack three octets into four hexets
	o1 = data.charCodeAt(i++);
	o2 = data.charCodeAt(i++);
	o3 = data.charCodeAt(i++);
	
	bits = o1 << 16 | o2 << 8 | o3;
	
	h1 = bits >> 18 & 0x3f;
	h2 = bits >> 12 & 0x3f;
	h3 = bits >> 6 & 0x3f;
	h4 = bits & 0x3f;
	
	// use hexets to index into b64, and append result to encoded string
	tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
	} while (i < data.length);
	
	enc = tmp_arr.join('');
	var r = data.length % 3;
	
	return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
}

function resetPassword(form, email) {
	var allChar = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	var tempPassword = "";
	var uppercaseCheck = 0;
	var lowercaseCheck = 0;
	var numberCheck = 0;
	
	for(var i = 0; i < 8; i++)
		tempPassword += allChar.charAt(Math.floor(Math.random() * allChar.length));
	
	for(i = 0; i < tempPassword.length; i++) {
		if('A' <= tempPassword[i] && tempPassword[i] <= 'Z') {
			uppercaseCheck++;
		}
		if('a' <= tempPassword[i] && tempPassword[i] <= 'z') {
			lowercaseCheck++;
		}
		if('0' <= tempPassword[i] && tempPassword[i] <= '9') {
			numberCheck++;
		}
	}
	
	if(uppercaseCheck > 0 && lowercaseCheck > 0 && numberCheck > 0) {	
		var p = document.createElement("input");
 
		// Add the new element to form
		form.appendChild(p);
		p.name = "p";
		p.type = "hidden";
		p.value = tempPassword;
		
		form.submit();
		
	} else {
		resetPassword(email);
	}
}

function newPass(form, oldPassword, newPassword, confirmPassword) {
	// Check if any fields are empty
    if (oldPassword.value == '' || newPassword.value == '' || confirmPassword.value == '') {
		new Messi("You must provide all the requested details. Please try again.", {title: 'Error', modal: true, width: 'auto'});
        return false;
    }
	
	// Check if password is at least 6 characters long
    if (newPassword.value.length < 6) {
		new Messi("Passwords must be at least 6 characters long. Please try again.", {title: 'Error', modal: true, width: 'auto'});
        form.newPassword.focus();
        return false;
    }
 
    // RegEx Test: Password must have at least one uppercase, one lowercase, and one number
    var regEx = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!regEx.test(newPassword.value)) {
		new Messi("Passwords must contain at least one uppercase letter, one lowercase letter, and one number.", 
			{title: 'Error', modal: true, width: 'auto'});
        return false;
    }
 
    // Check password and confirmation are the same
    if (newPassword.value != confirmPassword.value) {
		new Messi("Your password and confirmation do not match. Please try again.", {title: 'Error', modal: true, width: 'auto'});
        form.newPassword.focus();
        return false;
    }
			
	// Create a new element input, this will be our hashed password field. 
	var p = document.createElement("input");
	var p2 = document.createElement("input");
	
	// Add the new element to our form. 
	form.appendChild(p);
	p.name = "p";
	p.type = "hidden";
	p.value = hex_sha512(oldPassword.value);
	
	form.appendChild(p2);
	p2.name = "p2";
	p2.type = "hidden";
	p2.value = hex_sha512(newPassword.value);
	
	// Make sure the plaintext password doesn't get sent. 
	oldPassword.value = "";
	newPassword.value = "";
	confirmPassword.value = "";
	
	// Finally submit the form. 
	form.submit();
	return true;
}
