<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="public/img/smartcar_logo.ico">
    <link rel="stylesheet" type="text/css" href="public/css/basic_styling.css">
    <link rel="stylesheet" type="text/css" href="public/css/car_details.css">
    <script src="public/js/searchCars.js" defer></script>
    <title>OPIS SAMOCHODU</title>
</head>

<body>
    <div class="wrapper">
        <?php include_once __DIR__ . '/shared/nav.php' ?>
        <div class="wrapper_main">
            <div class="details_wrapper">
                <div class="car_image">
                    <img src="public/img/<?= $car['photo']; ?>" alt="car image">
                </div>
                <div class="car_details flex-column">
                    <h3><?= $car['brand_name']." ".$car['model']?></h3>
                    <p class="carLocations">
                        <i class='bx bx-map'></i>
                        <?php
                            $carLocations = explode(",", trim($car['locations'], "{}"));
                            echo implode(", ", $carLocations);
                        ?>
                    </p>
                    <p class="seats">
                        <i class='bx bx-calendar'></i>
                        <?php
                                $seats = $car['seats_available'];
                                $text = "osoby";
                                if($seats > 4){
                                    $text = "osób";
                                }
                                echo "$seats $text";
                                ?>
                    </p>
                    <p class="productionYear">
                        <i class='bx bx-body'></i>
                        <?= $car['production_year']?>
                    </p>
                    <p class="price">
                        <i class='bx bx-money'></i>
                        <?= $car['price_per_day']?>
                        PLN
                    </p>
                </div>
            </div>
            <div class="description flex-column">
                <h2>Opis</h2>
                <p><?= $car['car_description'] ;?></p>
                <div class="reservation_form">
                    <form action="" method="POST">
                        <label for="reservation_start_date">Od
                            <input type="date" name="reservation_start_date" id="reservation_start_date">
                        </label>
                        <label for="reservation_end_date">Do
                            <input type="date" name="reservation_end_date" id="reservation_end_date">
                        </label>
                        <label for="location_select">Miejsce wynajmu
                            <select name="location" id="location_select">
                                <option value="">Wszystkie</option>
                                <?php foreach ($locations as $location): ?>
                                <option value="<?= $location->getLocationName(); ?>">
                                    <?= $location->getLocationName(); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <button class="buttonClass">
                            Zarezerwuj
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>
</body>

</html>