const navLinks = document.querySelectorAll(".navParts a")
const currentPage = window.location.href;

navLinks.forEach(navLink => {
    if(currentPage === navLink.href){
        navLink.classList.add("active")
    }
    // link = navLink.href.split("/").pop()
    // console.log(link)
})
