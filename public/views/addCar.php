<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="public/img/smartcar_logo.ico">
    <link rel="stylesheet" type="text/css" href="public/css/basic_styling.css">
    <link rel="stylesheet" type="text/css" href="public/css/carAdmin.css">
    <title>DODAWANIE - ADMIN</title>
</head>

<body>
<div class="wrapper">
    <?php include_once __DIR__ . '/shared/nav.php' ?>
    <div class="wrapper_main flex-column">
        <h2>Dodaj auto</h2>
        <div class="form_wrapper">
            <form action="/addCar" class="flex-column" method="POST" ENCTYPE="multipart/form-data">
                <label for="car_photo">Zdjęcie
                    <input type="file" name="car_photo" id="car_photo" >
                </label>
                <label for="brand_select">Marka
                    <select name="brand" id="brand_select">
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?= $brand->getBrandId(); ?>"><?= $brand->getBrandName();; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label for="model_select">Model
                    <input type="text" name="model_select" id="model_select" placeholder="Model samochodu">
                </label>
                <label for="price_input">Cena
                    <input type="number" name="price_input" id="price_input">
                </label>
                <label for="seats_select">Liczba miejsc
                    <select name="seats" id="seats_select">
                        <option value="4">4 miejsc</option>
                        <option value="5">5 miejsc</option>
                        <option value="7">7 miejsc</option>
                    </select>
                </label>
                <label for="production_year">Rok produkcji
                    <input type="number" name="production_year" id="production_year" placeholder="Rok produkcji" min="1900" max="2024">
                </label>
                <div class="checkbox">
                    <span>Dostępne lokalizacje</span>
                    <div class="checkbox_wrapper flex-row">
                    <?php foreach ($locations as $location): ?>
                        <label for="<?= $location->getLocationId(); ?>"><?= $location->getLocationName(); ?>
                            <input type="checkbox" name="locations[]" id="<?= $location->getLocationId(); ?>" value="<?= $location->getLocationId(); ?>" />
                        </label>
                    <?php endforeach; ?>
                    </div>
                </div>
                <label for="car_description">Opis samochodu
                    <textarea name="car_description" id="car_description" rows="7" placeholder="Dodaj opis samochodu"></textarea>
                </label>

                <button type="submit">Dodaj samochód</button>
            </form>
        </div>
    </div>
    <div class="message <?php if(!empty($messages)) echo 'visible'; ?>" >
        <p>
            <?php
            if(isset($messages)) {
                foreach ($messages as $message) {
                    echo $message;
                }
            }
            ?>
        </p>
        <span class="close_modal">&#10006;</span>
    </div>
</body>

</html>