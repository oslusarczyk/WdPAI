const inputsValue = document.querySelectorAll("form select, form input")
const carsWrapper = document.querySelector(".carsWrapper")

async function filterCars(){
    const data = {}
    inputsValue.forEach(input => {
        data[input.name] = input.value
    });

    console.log(data)
    const response = await fetch("/filterCars", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    const cars = await response.json();
    carsWrapper.innerHTML = ""
    if(cars.length == 0 ){
        carsWrapper.innerHTML = "<p class='carsNotFound'>Nie znaleziono samochodów z podanymi parametrami</p>"
    }
    cars.forEach(car => {
        createCarCard(car);
    })
}

function createCarCard(car){
    const template = document.querySelector("#car-template")
    const clone = template.content.cloneNode(true);

    const img = clone.querySelector("img");
    const carName = clone.querySelector("h4");
    const carLocations = clone.querySelector(".carLocations")
    const carSeats = clone.querySelector(".seats")
    const carPrice = clone.querySelector(".price")
    const carHref = clone.querySelector("a")

    img.src = "public/img/" + car.photo

    carName.innerHTML = car.brand_name + " " + car.model
    const carLocationsLength = car.locations.split(",").length
    let carText = "lokalizacja";
    if(carLocationsLength >= 2 && carLocationsLength <= 4){
        carText = "lokalizacje";
    } else if(carLocationsLength > 5){
        carText = "lokalizacji";
    }
    carLocations.innerHTML += carLocationsLength + " " + carText


    const seatsAvailable = car.seats_available
    let seatsText = "osoby";
    if(seatsAvailable >4){
        seatsText = "osób";
    } 
    carSeats.innerHTML += seatsAvailable + " " + seatsText

    carPrice.innerHTML += "od " + car.price_per_day + " PLN"

    carHref.href = "/$id="+ car.car_id
    carsWrapper.appendChild(clone);

}



inputsValue.forEach(input => input.addEventListener("change", filterCars));

