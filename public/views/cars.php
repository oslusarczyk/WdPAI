<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="public/img/smartcar_logo.ico">
    <link rel="stylesheet" type="text/css" href="public/css/basic_styling.css">
    <link rel="stylesheet" type="text/css" href="public/css/main.css">
    <script src="public/js/searchCars.js" defer></script>
    <title>SAMOCHODY</title>
</head>

<body>
    <div class="wrapper">
        <?php include_once __DIR__ . '/shared/nav.php' ?>
        <div class="wrapper_main">
            <div class="header flex-column">
                <div class="form_wrapper search flex-column">
                    <h3>Wyszukaj</h3>
                    <form class="flex-column search" action="" method="POST">
                        <label for="location_select">Miejsce wynajmu
                            <select name="location" id="location_select">
                                <option value="">Wszystkie</option>
                                <?php foreach ($locations as $location): ?>
                                <option value="<?= $location->getLocationName(); ?>"
                                    <?= $location->getLocationName() == $selectedLocation ? 'selected' : ''; ?>>
                                    <?= $location->getLocationName(); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label for="brand_select">Marka
                            <select name="brand" id="brand_select">
                                <option value="">Wszystkie</option>
                                <?php foreach ($brands as $brand): ?>
                                <option value="<?= $brand->getBrandName(); ?>"><?= $brand->getBrandName();; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label for="seats_select">Liczba miejsc
                            <select name="seats" id="seats_select">
                                <option value="">Dowolne</option>
                                <option value="4">4 miejsc</option>
                                <option value="5">5 miejsc</option>
                                <option value="7">7 miejsc</option>
                            </select>
                        </label>
                        <div class="price_range">
                            <label for="price_min">Cena minimalna
                                <input type="number" name="price_min" id="price_min" min="0" max="500">
                            </label>
                            <label for="price_max">Cena maksymalna
                                <input type="number" name="price_max" id="price_max" min="0" max="500">
                            </label>
                        </div>

                    </form>
                </div>
            </div>
            <div class="mainPage">
                <template id="car-template">
                    <div class="carCard">
                        <div class="leftPart">
                            <img src="" alt="car image">
                        </div>
                        <div class="rightPart flex-column">
                            <h4 class="carName"></h4>
                            <p class="carLocations">
                                <i class='bx bx-map'></i>
                            </p>
                            <p class="seats">
                                <i class='bx bx-body'></i>
                            </p>
                            <p class="price"></p>
                            <button class="buttonClass">
                                <a href="">
                                    Zobacz więcej
                                </a>
                            </button>
                        </div>
                    </div>
                </template>


                <h2>Dostępne samochody</h2>
                <div class="carsWrapper">
                    <?php foreach ($cars as $car): ?>
                    <div class="carCard">
                        <div class="leftPart">
                            <img src="public/img/<?= $car['photo'] ?>" alt="car image">
                        </div>
                        <div class="rightPart flex-column">
                            <h4 class="carName"><?= $car['brand_name']." ".$car['model']?></h4>
                            <p class="carLocations">
                                <i class='bx bx-map'></i>
                                <?php
                                $locationsCount = count(explode(",", $car['locations']));
                                $text = "lokalizacja";
                                if($locationsCount >= 2 && $locationsCount <= 4){
                                    $text = "lokalizacje";
                                } else if($locationsCount > 5){
                                    $text = "lokalizacji";
                                }
                                echo "$locationsCount $text";
                            ?>
                            </p>
                            <p class="seats">
                                <i class='bx bx-body'></i>
                                <?php
                                $seats = $car['seats_available'];
                                $text = "osoby";
                                if($seats > 4){
                                    $text = "osób";
                                }
                                echo "$seats $text";
                                ?>
                            </p>
                            <p class="price">od <?= $car['price_per_day'] ?> PLN</p>
                            <button class="buttonClass">
                                <a href="/$id=<?=$car['car_id'] ?>">
                                    Zobacz więcej
                                </a>
                            </button>

                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</body>

</html>