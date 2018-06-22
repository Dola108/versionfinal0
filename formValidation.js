function formValidation() {
	// Make quick references to our fields.
	var username = document.getElementById('uname');
	var pass1 = document.getElementById('psw0');
	var pass2 = document.getElementById('pswcon');
	var email = document.getElementById('email');
	var age = document.getElementById('ageid');
	
	// Check each input in the order that it appears in the form.
	if (textAlphanumeric(username, "* For your name please use alphabets and numbers only *")) {
		if (lengthDefine(username, 4, 25)) {
			if (emailValidation(email, "* Please enter a valid email address *")) {
				if (textPass(pass1, "* Invalid password *")) {
					if(plengthDefine(pass1, 6, 40)) {
						if (textNumeric(age, "* Please enter a valid age *")) {
							if (passwordMatch(pass2, "* Passwords didn't match *")) {
								return true;
							}
						}
					}
				}
			}
		}
	}
	return false;
}

function passwordMatch(inputtext, alertMsg) {
	var pass1 = document.getElementById('psw0');
	
	if (inputtext.value == pass1.value) {
		return true;
	} else {
		document.getElementById('message').innerText = alertMsg;
		document.getElementById('message').style.color = 'red';
		inputtext.focus();
		return false;
	}
}

function textPass(inputtext, alertMsg) {
	var alphaExp = /^[0-9a-zA-Z]+$/;
	if (inputtext.value.match(alphaExp)) {
		return true;
	} else {
		document.getElementById('p1').innerText = alertMsg;
    	document.getElementById('p1').style.color = 'red'; // This segment displays the validation rule for zip.
		inputtext.focus();
		return false;
	}
}

// Function that checks whether input text includes alphabetic and numeric characters.
function textAlphanumeric(inputtext, alertMsg) {
	var alphaExp = /^[0-9a-zA-Z _]+$/;
	if (inputtext.value.match(alphaExp)) {
		document.getElementById('un').innerText = ""; 
		return true;
	} else {
		document.getElementById('un').innerText = alertMsg; 
    	document.getElementById('un').style.color = 'red'; // This segment displays the validation rule for address.
		inputtext.focus();
		return false;
	}
}

function textNumeric(inputtext, alertMsg) {
	var alphaExp = /^[0-9]+$/;
	if (inputtext.value.match(alphaExp)) {
		return true;
	} else if (inputtext.value.match("")) {
		return true;
	} else {
		document.getElementById('age').innerText = alertMsg; 
    	document.getElementById('age').style.color = 'red'; // This segment displays the validation rule for address.
		inputtext.focus();
		return false;
	}
}

// Function that checks whether the input characters are restricted according to defined by user.
function lengthDefine(inputtext, min, max) {
	var uInput = inputtext.value;
	if (uInput.length >= min && uInput.length <= max) {
		return true;
	} else {
		document.getElementById('un').innerText = "* Please enter between " + min + " and " + max + " characters *";
    	document.getElementById('un').style.color = 'red';  // This segment displays the validation rule for username
		inputtext.focus();
		return false;
	}
}

function plengthDefine(inputtext, min, max) {
	var uInput = inputtext.value;
	if (uInput.length >= min && uInput.length <= max) {
		return true;
	} else {
		document.getElementById('message').innerText = "* Please enter between " + min + " and " + max + " characters *";
    	document.getElementById('message').style.color = 'red';  // This segment displays the validation rule for username
		inputtext.focus();
		return false;
	}
}

// Function that checks whether an user entered valid email address or not and displays alert message on wrong email address format.
function emailValidation(inputtext, alertMsg) {
	var emailExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if (inputtext.value.match(emailExp)) {
		return true;
	} else {
		document.getElementById('em').innerText = alertMsg; // This segment displays the validation rule for email.
    	document.getElementById('em').style.color = 'red'; 
		inputtext.focus();
		return false;
	}
}

