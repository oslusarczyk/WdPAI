<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/basic_styling.css">
    <link rel="stylesheet" href="public/css/login.css">

    <title>LOGIN</title>
</head>
<body>
    <div class="header">
        <img src="public\img\smartcar_logo.png" alt="SmartCar logo">
    </div>
    <div class="wrapper">
        <div class="image_wrapper">
            <img src="public\img\car_logo.jpg" alt="car image">
            <div class="text_wrapper">
            <p class="image_text">Wynajem samochodów w kilkunastu lokalizacjach</p>
            </div>
            
        </div>
        <div class="form_wrapper">
            <h2>Witaj!</h2>
            <form action="login" method="POST">
                <input type="email" id="email" required placeholder="test@gmail.com">
                <input type="password" name="password" required placeholder="password">

                <button type="sumbit">Zaloguj się</button>
            </form>
            <p>Nie masz konta? <a href="/register">Zarejestruj się</a></p>
            <?php
                if(isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message;
                    }
                }
                ?>
        </div>
    </div>
</body>
</html>