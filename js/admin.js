// var deletionRequest = document.querySelectorAll('.deletion_request');

// deletionRequest.forEach(element => {
//     element.addEventListener("click", function(e) {
//         if(confirm("Êtes-vous sûr d'exécuter cette action ?")){
//             document.location.href = "../config/deleteUser.php";
//         }  
//     })
// });

function Supp(link){
    if(confirm('Confirmer la suppression ?')){
     document.location.href = link;
    }
}