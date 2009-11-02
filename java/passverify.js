function verify() {
//alert if fields are empty and cancel form submit
if (document.changepass.pass1.value == document.changepass.pass2.value) {
document.changepass.submit();
}
else {
alert("The Passwords Do Not Match");
return false;
   }
}

function nverify() {
var themessage = "You are required to complete the following fields: ";
if (document.newuser.first.value=="") {
themessage = themessage + "First Name";
}
if (document.newuser.last.value=="") {
themessage = themessage + " Last Name";
}
if (document.newuser.username.value=="") {
themessage = themessage + " Username";
}
if (document.newuser.pass1.value=="") {
themessage = themessage + " Password 1";
}
if (document.newuser.pass2.value=="") {
themessage = themessage + " Password 2";
}
if (document.newuser.weight.value=="") {
themessage = themessage + " Weight";
}

//alert if fields are empty and cancel form submit
if (themessage == "You are required to complete the following fields: ") {
if (document.newuser.pass1.value == document.newuser.pass2.value) {
document.newuser.submit();
}
else {
alert("The Passwords Do Not Match");
return false;
   }
}
else {
alert(themessage);
return false;
   }
}
