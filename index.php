<?php
session_start();
if (filter_input(INPUT_GET, "action") == "wyloguj" && isset($_SESSION["id"])) {
    var_dump($_SESSION);
    session_unset();
    session_destroy();
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- title -->
    <title>Sklep | Strona główna</title>

    <!-- styles -->
    <link rel="stylesheet" href="styles/core.css">
    <link rel="stylesheet" href="styles/index.css">

    <!-- icon -->
    <link rel="icon" href="images/favicon.png">

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

    <!-- fontawesome -->
    <link href="fas/css/all.css" rel="stylesheet">

</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg text-uppercase fixed-top">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger active" href="index.php">Sklep</a>
            <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <?php
                    if (isset($_SESSION["id"])) {
                        echo '<li class="nav-item mx-0 mx-lg-1">
                                <a class="nav-link py-3 px-0 px-lg-3" href="pages/Market.php">Rynek</a>
                            </li>';
                        echo '<li class="nav-item mx-0 mx-lg-1">
                                <a class="nav-link py-3 px-0 px-lg-3" href="pages/Cart.php">Koszyk</a>
                            </li>';
                        echo '<li class="nav-item mx-0 mx-lg-1">
                                <a class="nav-link py-3 px-0 px-lg-3" href="pages/Store.php">Własne</a>
                            </li>';
                        echo '<li class="nav-item mx-0 mx-lg-1">
                                    <a class="nav-link py-3 px-0 px-lg-3" href="pages/Add.php">Wystaw</a>
                                </li>';
                        echo '<li class="nav-item mx-0 mx-lg-1">
                                        <a class="nav-link py-3 px-0 px-lg-3" href="pages/Account.php">Konto</a>
                                    </li>';
                        echo '<li class="nav-item mx-0 mx-lg-1">
                                <a class="nav-link py-3 px-0 px-lg-3" href="?action=wyloguj">Wyloguj</a>
                            </li>';
                    } else {
                        echo '<li class="nav-item mx-0 mx-lg-1">
                                <a class="nav-link py-3 px-0 px-lg-3" href="pages/Login.php">Logowanie</a>
                            </li>';
                        echo '<li class="nav-item mx-0 mx-lg-1">
                                <a class="nav-link py-3 px-0 px-lg-3" href="pages/Registration.php">Rejestracja</a>
                            </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- mainContent -->
    <section id="mainContent">
        <span class="main-content-text">Strona główna</span><br />
        <img src="images/shop-img.png" id="shop-img" alt="shop-img" /><br />
        <span style="font-size: 20px">Sklep internetowy</span>
    </section>

    <!-- footer -->
    <footer>
        <span class="footer-primary-text">O FIRMIE</span><br />
        <span class="footer-secondary-text">Serwis internetowy dający możliwość kupowania i sprzedawania produktów przez Internet</span><br /><br />
        <span class="footer-primary-text">KONTAKT</span><br />
        <a href=""><i class="fab contact-icon fa-facebook"></i></a>
        <a href=""><i class="fas contact-icon fa-envelope"></i></a>
        <a href=""><i class="fab contact-icon fa-twitter"></i></a>
        <a href=""><i class="fab contact-icon fa-google-plus"></i></a><br /><br />
        <span class="footer-secondary-text" id="timer"></span>
    </footer>

    <!-- copyright -->
    <section id="copyright">
        Copyright © Mateusz Kozak 2020
    </section>

    <!-- timer -->
    <script type="text/javascript" src="scripts/timer.js"></script>

</body>

</html>