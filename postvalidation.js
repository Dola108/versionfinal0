function postValidation(event) {
	event.preventDefault();
	var count = 0;
	if (document.getElementById('posst').value.match(/#[A-Za-z0-9_]+/g)) {
		count++;
		if (count>1) {
			document.getElementById('un').innerText = "Please enter only one hashtag!";
		}
		return true;
	}
}

// Function that checks whether input text includes alphabetic and numeric characters.
//function hashtext(inputtext, alertMsg) {
//	var count = 1;
//	var alphaExp = /^#[0-9a-zA-Z _]+$/;
//	if (inputtext.match(/#[a-z0-9_]+/g)) {
//		count++;
//		if (count<=1) {
//			return true;
//		}
//		 else {
//			document.getElementById('un').innerText = alertMsg; 
//	   		document.getElementById('un').style.color = 'red'; // This segment displays the validation rule for address.
//			inputtext.focus();
//			return false;
//		}
//	} else {
//		document.getElementById('un').innerText = "Invalid hashtag!!!!"; 
//   		document.getElementById('un').style.color = 'red'; // This segment displays the validation rule for address.
//		inputtext.focus();
//		return false;
//	}
//	//if (inputtext.value.match(alphaExp)) {
//	//	return true;
//	//} else {
//	//	document.getElementById('un').innerText = alertMsg; 
//   // 	document.getElementById('un').style.color = 'red'; // This segment displays the validation rule for address.
//	//	inputtext.focus();
//	//	return false;
//	//}
//}