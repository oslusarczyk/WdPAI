const closeModal = document.querySelector(".close_modal");
const navLinks = document.querySelectorAll(".navParts a")
const currentPage = window.location.href;

if(closeModal){
    closeModal.addEventListener("click", (event) => {
        event.target.closest(".message").classList.remove("visible");
    })
}

navLinks.forEach(navLink => {
    if(currentPage === navLink.href){
        navLink.classList.add("active")
    }
})
