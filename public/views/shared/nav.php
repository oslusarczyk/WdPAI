<script src="public\js\utils.js" defer></script>
<link rel="stylesheet" type="text/css" href="public/css/nav.css">
<nav class="flex-column">
    <div class="header_logo">
        <img src="public\img\smartcar_logo.png" alt="SmartCar logo">
    </div>
    <div class="navParts flex-column">
        <a href="/main"><i class='bx bx-home'></i>
            <p>główna</p>
        </a>
        <a href="/cars"><i class='bx bx-car'></i>
            <p>samochody</p>
        </a>
        <a href="/history"><i class='bx bx-history'></i>
            <p>historia</p>
        </a>

        <?php
            if(isAdmin()){
                echo '<a class="end" href="/carAdmin"><i class="bx bx-calendar"></i>
                <p>rezerwacje</p>
                 </a>';
                echo '<a class="end" href="/addCar"><i class="bx bx-car"></i>
                <p>dodawanie</p>
                 </a>';
            };

            ?>
        <a class="end" href="/logout"><i class='bx bx-log-out'></i>
            <p>wyloguj</p>
        </a>

    </div>
</nav>