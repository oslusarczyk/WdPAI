<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="public/img/smartcar_logo.ico">
    <link rel="stylesheet" type="text/css" href="public/css/basic_styling.css" />
    <link rel="stylesheet" type="text/css" href="public/css/login.css" />
    <script src="public\js\utils.js" defer></script>
    <title>LOGIN</title>
</head>
<body>
    <div class="header_logo">
        <img src="public\img\smartcar_logo.png" alt="SmartCar logo">
    </div>
    <div class="flex-row wrapper">
        <div class="image_wrapper">
            <img src="public\img\car_logo.jpg" alt="car image">
            <div class="text_wrapper">
            <p class="image_text">Wynajem samochodów w kilkunastu lokalizacjach</p>
            </div>
            
        </div>
        <div class="form_wrapper flex-column">
            <h2>Witaj!</h2>
            <form class="flex-column" action="login" method="POST">
                <label for="email">E-mail
                <input type="email" name="email" required placeholder="test@gmail.com">
                </label>
                <label for="password">Hasło
                <input type="password" name="password" required placeholder="hasło">
                </label>
                

                <button type="submit">Zaloguj się</button>
            </form>
            <p>Nie masz konta? <a href="/register">Zarejestruj się</a></p>
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