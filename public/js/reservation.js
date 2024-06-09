//
// const button = document.querySelector("button");
// const inputs = document.querySelectorAll("input, select");
// let startDate, endDate, selectedLocation, isValid;
// function validateForm(){
//     startDate = new Date(inputs[0].value).toLocaleDateString();
//     endDate = new Date(inputs[1].value).toLocaleDateString();
//     selectedLocation = inputs[2].value !== "";
//     isValid = true;
//
//     if(!isNaN(startDate) || !isNaN(endDate) || !selectedLocation){
//         isValid = false;
//     }
//
//     if (startDate >= endDate) {
//         isValid = false;
//     }
//     button.disabled = !isValid;
//     console.log(startDate,endDate,selectedLocation);
// }
//
// inputs.forEach(input => input.addEventListener("change", validateForm));
// validateForm()
//
//
//
