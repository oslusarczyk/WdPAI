<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="public/img/smartcar_logo.ico">
    <link rel="stylesheet" type="text/css" href="public/css/basic_styling.css">
    <link rel="stylesheet" type="text/css" href="public/css/history.css">
    <title>HISTORIA</title>
</head>

<body>
    <div class="wrapper">
        <?php include_once __DIR__ . '/shared/nav.php' ?>
        <div class="wrapper_main">
            <div class="confirmed_wrapper">
                <?php if (empty($confirmed)): ?>
                <h2>Brak potwierdzonych rezerwacji</h2>
                <?php else : ?>
                <h2>Potwierdzone rezerwacje</h2>
                <div class="confirmed_reservation_wrapper grid_row">
                <?php foreach ($confirmed as $reservation): ?>
                <div class="carCard">
                    <div class="leftPart">
                        <img src="public/img/uploads/<?= $reservation->getPhoto(); ?>" alt="car image">
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
                        <p class="price"><?= $reservation->getReservationPrice(); ?> PLN</p>
                    </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif ;?>
                                        
                </div>
            <div class="pending_wrapper">
                <?php if (empty($pending)): ?>
                <h2>Brak oczekujących rezerwacji</h2>
                <?php else : ?>
                <h2>Oczekujące rezerwacje</h2>
                <div class="pending_reservation_wrapper grid_row">
                <?php foreach ($pending as $reservation): ?>
                <div class="carCard">
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
                        <p class="price"><?= $reservation->getReservationPrice(); ?> PLN</p>
                    </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif ;?>
            </div>


        </div>
</body>

</html>