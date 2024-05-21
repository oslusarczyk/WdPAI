const closeModal = document.querySelector(".close_modal");
const nav = document.querySelector("nav")
const navLinks = document.querySelectorAll(".navParts a")
const currentPageLink = window.location.href;

if(closeModal){
    closeModal.addEventListener("click", (event) => {
        event.target.closest(".message").classList.remove("visible");
    })
}

navLinks.forEach(navLink => {
    if(currentPageLink === navLink.href){
        navLink.classList.add("active")
    }
})


document.addEventListener("scroll", () => {
    if(window.scrollY > window.innerHeight){
        nav.classList.add("scroll")
    } else{
        nav.classList.remove("scroll")
    }
})