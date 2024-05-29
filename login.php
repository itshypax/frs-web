<?php
ini_set('session.gc_maxlifetime', 604800);
ini_set('session.cookie_path', '/');  // Set the cookie path to the root directory
ini_set('session.cookie_domain', '.frs-stettbeck.de');  // Set the cookie domain to your domain
ini_set('session.cookie_lifetime', 604800);  // Set the cookie lifetime (in seconds)
ini_set('session.cookie_secure', true);  // Set to true if using HTTPS, false otherwise

session_start();
require_once './config/config.php';
$pdo = new PDO('mysql:host=' . MYSQL_ROOT . ';dbname=' . MYSQL_DB, MYSQL_USER, MYSQL_PASS);

if (isset($_SESSION['userid'])) {
    header('Location: /dashboard.php');
}

if (isset($_GET['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $result = $statement->execute(array('username' => $username));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];

        if (isset($_SESSION['redirect_url'])) {
            $redirect_url = $_SESSION['redirect_url'];
            unset($_SESSION['redirect_url']); // Remove the stored URL
            header("Location: $redirect_url");
            exit();
        } else {
            header('Location: /dashboard.php');
        }
    } else {
        $errorMessage = "Benutzername oder Passwort ungültig.<br>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login &rsaquo; FRS-Portal</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/src/css/main.min.css" />
    <link rel="stylesheet" href="/src/fonts/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="/src/fonts/ptsans/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/src/assets/bootstrap-5.3/css/bootstrap.min.css">
    <script src="/src/assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
    <script src="/src/assets/jquery/jquery-3.7.0.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/src/icon/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/src/icon/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/src/icon/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/src/icon/apple-touch-icon.png">
    <link rel="manifest" href="/src/icon/site.webmanifest">
    <!-- Metas -->
    <meta property="og:image" content="https://stettbeck.de/assets/img/STETTBECK_1.png" />
    <meta property="og:description" content="Portal der FRS Stettbeck" />
</head>

<body id="loginpage" class="d-flex justify-content-center align-items-center" style="height:100vh;width:100vw">
    <div class="row">
        <div class="col">
            <div class="card p-3 rounded-3 shadow-lg text-center">
                <img src="/src/img/FRSS.png" alt="FRSS" height="128px" width="auto">
                <hr class="mx-5">
                <?php
                if (isset($errorMessage)) {
                    echo '<div class="alert alert-danger mb-5" role="alert">';
                    echo $errorMessage;
                    echo '</div>';
                }
                ?>

                <form action="?login=1" method="post">
                    Benutzername<br>
                    <input class="form-control" type="text" size="40" maxlength="250" name="username"><br><br>

                    Passwort<br>
                    <input class="form-control" type="password" size="40" maxlength="250" name="password"><br>

                    <input class="btn btn-primary w-100" type="submit" value="Anmelden">
                </form>
                <div class="mt-4" id="loginpage__footer">
                    Erstellt von Sunny & hypax. Mit <i class="fa-solid fa-heart"></i> und <i class="fa-solid fa-code"></i>.
                </div>
            </div>
        </div>
    </div>
</body>

</html>