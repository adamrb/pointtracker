function verify() {
var themessage = "You are required to complete the following fields: ";
if (document.newfood.food.value=="") {
themessage = themessage + "Food Name";
}
if (document.newfood.calories.value=="") {
themessage = themessage + " Calories";
}
if (document.newfood.fat.value=="") {
themessage = themessage + " Fat";
}
if (document.newfood.fiber.value=="") {
themessage = themessage + " Fiber";
}
//alert if fields are empty and cancel form submit
if (themessage == "You are required to complete the following fields: ") {
document.newfood.submit();
}
else {
alert(themessage);
return false;
   }
}
