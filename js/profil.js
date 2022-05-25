var addWeigth = document.getElementById("add_weight");
var popUp = document.getElementById("registration_success");
var closeBtn = document.querySelector('.close_btn');

// if(popUp){
//     document.addEventListener('click', function (e) {
//         popUp.style.visibility = "hidden"
//     })
// }

addWeigth.addEventListener("click", function (e) {
    popUp.style.visibility = "visible"
})

closeBtn.addEventListener("click", function (e) {
    popUp.style.visibility = "hidden"
})