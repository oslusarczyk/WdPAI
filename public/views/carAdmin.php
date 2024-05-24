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
    <script src="public/js/adminReservation.js" defer></script>
    <title>REZERWACJE - ADMIN</title>
</head>

<body>
    <div class="wrapper">
        <?php include_once __DIR__ . '/shared/nav.php' ?>
        <div class="wrapper_main">
            <div class="reservation_wrapper">
                <?php if (empty($reservations)): ?>
                <h2>Brak rezerwacji do potwierdzenia</h2>
                <?php else : ?>
                <h2>Rezerwacje do potwierdzenia</h2>
                <div class="pending_reservation_wrapper grid_row">
                    <?php foreach ($reservations as $reservation): ?>
                    <div class="carCard" id="<?= $reservation->getReservationId(); ?>">
                        <div class="leftPart">
                            <img src="public/img/<?= $reservation->getPhoto(); ?>" alt="car image">
                        </div>
                        <div class="rightPart flex-column">
                            <h4 class="carName"><?= $reservation->getCarName()?></h4>
                            <p class="reservation_start">
                                <i class='bx bx-calendar'></i>
                                od <?= $reservation->getReservationStartDate();?>
                            </p>
                            <p class="reservation_end">
                                <i class='bx bx-calendar'></i>
                                do <?= $reservation->getReservationEndDate();?>
                            </p>
                            <p class="reservation_end">
                                <i class='bx bx-map'></i>
                                <?= $reservation->getLocationName();?>
                            </p>    
                            <p class="reservation_email">
                                <i class='bx bx-body'></i>
                                <?= $reservation->getEmail();?>
                            </p>
                            <p class="price"><?= $reservation->getReservationPrice(); ?> PLN</p>
                            <div class="button_wrapper flex-row">
                            <button class="cancel" data-action="cancelled" >&#10005;</button>
                            <button class="confirm" data-action="confirmed">&#10004;</button>
                            </div>

                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif ;?>
                </div>
            </div>
        </div>
</body>

</html>