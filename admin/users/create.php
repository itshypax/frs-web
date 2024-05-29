<?php
session_start();
require_once '../../config/config.php';
$pdo = new PDO('mysql:host=' . MYSQL_ROOT . ';dbname=' . MYSQL_DB, MYSQL_USER, MYSQL_PASS);

if (isset($_POST['new']) && $_POST['new'] == 1) {
    $username = $_REQUEST['username'];
    $fullname = $_REQUEST['icname'];
    $password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
    $role = $_REQUEST['role'];
    $jetzt = date("Y-m-d H:i:s");

    $statement = $pdo->prepare("INSERT INTO users (username, password, fullname, role) VALUES (:username, :password, :fullname, :role)");
    $statement->execute(array('username' => $username, 'password' => $password, 'fullname' => $fullname, 'role' => $role));
    header("Location: /admin/users/list.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer erstellen &rsaquo; FRS-Portal</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../../src/css/main.min.css" />
    <link rel="stylesheet" href="../../src/fonts/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="../../src/fonts/ptsans/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../src/assets/bootstrap-5.3/css/bootstrap.min.css">
    <script src="../../src/assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
    <script src="../../src/assets/jquery/jquery-3.7.0.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../src/icon/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="../../src/icon/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../src/icon/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../../src/icon/apple-touch-icon.png">
    <link rel="manifest" href="../../src/icon/site.webmanifest">
    <!-- Metas -->
    <meta property="og:image" content="https://stettbeck.de/assets/img/STETTBECK_1.png" />
    <meta property="og:description" content="Portal der FRS Stettbeck" />
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" id="nav__main" style="position:relative">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="/src/img/FRSS.png" alt="FRSS" width="auto" height="64">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Startseite</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Lorem</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ipsum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Deaktiviert</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="scroll"></div>
    <section class="p-5" id="main">
        <div class="container">
            <div class="text__heading">
                <div class="text__heading-foreground">
                    <h1 class="text-center fw-bold mb-4">Benutzer erstellen</h1>
                </div>
            </div>
            <div class="row">
                <div class="col"></div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="">
                                <input type="hidden" name="new" id="new" value="1">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Benutzername">
                                <div class="input-group mt-3">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Passwort">
                                    <button class="btn btn-outline-dark" type="button" id="show_pw"><i class="fa-solid fa-eye"></i></button>
                                    <!-- <button class="btn btn-outline-dark" type="button" id="shuffle_pw"><i class="fa-solid fa-shuffle"></i></button> -->
                                    <!-- // ! FUNKTIONALITÄT FEHLT! -->
                                </div>
                                <hr class="my-3">
                                <input type="text" class="form-control" name="icname" id="icname" placeholder="Vor- und Zuname (IC)">
                                <select class="form-select mt-3" name="role" id="role">
                                    <option value="0">Gast</option>
                                    <option value="1">Benutzer</option>
                                    <option value="2">Lorem</option>
                                    <option value="3">Ipsum</option>
                                    <option value="4">Dolor</option>
                                </select>
                                <hr class="my-3">
                                <input class="btn btn-outline-success btn-sm" name="submit" type="submit" value="Benutzer anlegen" />
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </section>
    <div class="mt-4" id="footer__hover">
        Erstellt von Sunny & hypax. Mit <i class="fa-solid fa-heart"></i> und <i class="fa-solid fa-code"></i>.
    </div>
    <script src="/components/js/show_password.js"></script>
</body>

</html>