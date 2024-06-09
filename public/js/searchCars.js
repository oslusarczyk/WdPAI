const inputsValue = document.querySelectorAll("form select, form input");
const carsWrapper = document.querySelector(".carsWrapper");
const paginationWrapper = document.querySelector(".paginationWrapper");

let currentPage = 1;
let carsPerPage = getCarsPerPage();
let cars;

function getCarsPerPage() {
    return window.innerWidth <= 1024 ? 3 : 6;
}

window.addEventListener('resize', () => {
    const newCarsPerPage = getCarsPerPage();
    if (newCarsPerPage !== carsPerPage) {
        carsPerPage = newCarsPerPage;
        currentPage = 1;
        renderCars(cars,currentPage)
        renderPagination(cars);
    }
});


async function filterCars() {
    const data = {};
    inputsValue.forEach(input => {
        data[input.name] = input.value;
    });


    const response = await fetch("/filterCars", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    cars = await response.json();
    renderCars(cars, currentPage);
    renderPagination(cars);
}

function renderCars(cars, page) {
    carsWrapper.innerHTML = "";
    if (cars.length == 0) {
        carsWrapper.innerHTML = "<p class='carsNotFound'>Nie znaleziono samochodów z podanymi parametrami</p>";
        return;
    }
    const start = (page - 1) * carsPerPage;
    const end = start + carsPerPage;
    const carsToShow = cars.slice(start, end);

    carsToShow.forEach(car => {
        createCarCard(car);
    });
}

function renderPagination(cars) {
    paginationWrapper.innerHTML = "";
    const totalPages = Math.ceil(cars.length / carsPerPage);

    for (let i = 1; i <= totalPages; i++) {
        const pageButton = document.createElement("button");
        pageButton.textContent = i;
        pageButton.classList.add("pageButton");
        if (i === currentPage) {
            pageButton.classList.add("active");
        }
        pageButton.addEventListener("click", () => {
            currentPage = i;
            console.log(carsWrapper.getBoundingClientRect().x)
            window.scrollTo({ top: carsWrapper.getBoundingClientRect().x, behavior: 'smooth' })
            renderCars(cars,currentPage)
            updateActivePageButton();
        });
        paginationWrapper.appendChild(pageButton);
    }
}

function updateActivePageButton() {
    const buttons = paginationWrapper.querySelectorAll(".pageButton");
    buttons.forEach(button => {
        button.classList.remove("active");
        if (parseInt(button.textContent) === currentPage) {
            button.classList.add("active");
        }
    });
}


function createCarCard(car) {
    const template = document.querySelector("#car-template");
    const clone = template.content.cloneNode(true);

    const img = clone.querySelector("img");
    const carName = clone.querySelector("h4");
    const carLocations = clone.querySelector(".carLocations");
    const carSeats = clone.querySelector(".seats");
    const carPrice = clone.querySelector(".price");
    const carHref = clone.querySelector("a");

    img.src = "public/img/uploads/" + car.photo;

    carName.innerHTML = car.brand_name + " " + car.model;
    const carLocationsLength = car.locations.split(",").length;
    let carText = "lokalizacja";
    if (carLocationsLength >= 2 && carLocationsLength <= 4) {
        carText = "lokalizacje";
    } else if (carLocationsLength > 5) {
        carText = "lokalizacji";
    }
    carLocations.innerHTML += carLocationsLength + " " + carText;

    const seatsAvailable = car.seats_available;
    let seatsText = "osoby";
    if (seatsAvailable > 4) {
        seatsText = "osób";
    }
    carSeats.innerHTML += seatsAvailable + " " + seatsText;

    carPrice.innerHTML += "od " + car.price_per_day + " PLN";

    carHref.href = "carDetails?id=" + car.car_id;
    carsWrapper.appendChild(clone);
}

inputsValue.forEach(input => input.addEventListener("change", () => {
    currentPage = 1;
    filterCars();
}));

filterCars();