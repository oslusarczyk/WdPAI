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
    <title>STRONA GŁÓWNA</title>
</head>

<body>
    <div class="wrapper">
        <?php include_once __DIR__ . '/shared/nav.php' ?>
        <div class="wrapper_main">
            <div class="header flex-column">
                <div class="form_wrapper flex-column">
                    <h3>Wynajmij auto</h3>
                    <form class="flex-column" action="/cars" method="GET">
                        <label for="location_select">Miejsce wynajmu
                        <select name="location" id="location_select">
                            <?php foreach ($locations as $location): ?>
                            <option value="<?= $location->getLocationName(); ?>"><?= $location->getLocationName(); ?></option>
                            <?php endforeach; ?>
                        </select>
                        </label>
                        <button type="submit">Szukaj</button>
                    </form>
                </div>
            </div>
            <div class="mainPage">
                <h2>Najpopularniejsze samochody</h2>
                <div class="carsWrapper grid_row">
                    <?php foreach ($cars as $car): ?>
                    <div class="carCard">
                        <div class="leftPart">
                            <img src="public/img/uploads/<?= $car->getPhoto(); ?>" alt="car image">
                        </div>
                        <div class="rightPart flex-column">
                            <h4 class="carName"><?= $car->getBrand()." ".$car->getModel()?></h4>
                            <p class="carLocations">
                                <i class='bx bx-map'></i>
                                <?php
                                $locationsCount = count(explode(",", $car->getLocations()));
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
                                $seats = $car->getSeatsAvailable();
                                $text = "osoby";
                                if($seats > 4){
                                    $text = "osób";
                                }
                                echo "$seats $text";
                                ?>
                            </p>
                            <p class="price">od <?= $car->getPricePerDay(); ?> PLN</p>
                            <button class="buttonClass">
                                <a href="/carDetails?id=<?=$car->getId(); ?>">
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