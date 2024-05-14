<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="public/img/smartcar_logo.ico">
    <link rel="stylesheet" type="text/css" href="public/css/basic_styling.css">
    <link rel="stylesheet" type="text/css" href="public/css/nav.css">
    <link rel="stylesheet" type="text/css" href="public/css/main.css">

    <title>STRONA GŁÓWNA</title>
</head>

<body>
    <div class="wrapper">
        <?php include_once __DIR__ . '/shared/nav.php' ?>
        <div class="wrapper_main">
            <div class="header">
                <div class="form_wrapper">
                    <h3>Wynajmij auto</h3>
                    <form action="" method="POST">
                        <label for="location_select">Miejsce wynajmu
                        </label>
                        <select name="location" id="location_select">
                            <?php foreach ($locations as $location): ?>
                                <option value="<?= $location->getLocationName(); ?>"><?= $location->getLocationName(); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Szukaj</button>
                    </form>
                </div>
            </div>
            <div class="main">
                <h2>Najpopularniejsze auta</h2>
            </div>
        </div>
    </div>

</body>

</html>