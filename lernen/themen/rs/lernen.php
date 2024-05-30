<?php
session_start();
require_once '../../config/config.php';

if (!isset($_GET['thema'])) {
    header("Location: /index.html");
}

if (isset($_GET['result'])) {
    $frageget = $pdo->prepare("SELECT* FROM fragenkatalog_rs WHERE thema = :thema AND id = :id");
    $frageget->execute(array('thema' => $_GET['thema'], 'id' => $_GET['result']));

    $resultget = $pdo->prepare("SELECT * FROM lernfortschritt WHERE fragenid = :id AND userid = :uid ORDER BY timestamp DESC LIMIT 1");
    $resultget->execute(array('id' => $_GET['result'], 'uid' => $_SESSION['id']));
    $result = $resultget->fetch();
} else {
    $frageget = $pdo->prepare("SELECT* FROM fragenkatalog_rs WHERE thema = :thema ORDER BY RAND() LIMIT 1");
    $frageget->execute(array('thema' => $_GET['thema']));
}
$frage = $frageget->fetch();

if (isset($_POST['new']) && $_POST['new'] == 1) {
    $id = $_POST['id'];
    $thema = $_POST['thema'];
    $antwort_1 = $_POST['antwort_1'] ?? 0;
    $antwort_2 = $_POST['antwort_2'] ?? 0;
    $antwort_3 = $_POST['antwort_3'] ?? 0;

    if ($antwort_1 == $frage['antwort_1_true'] && $antwort_2 == $frage['antwort_2_true'] && $antwort_3 == $frage['antwort_3_true']) {
        $antwort_check = true;
    } else {
        $antwort_check = false;
    }
    $insert = $pdo->prepare("INSERT INTO lernfortschritt (userid, fragenid, antwort_1, antwort_2, antwort_3, ergebnis) VALUES (:uid, :id, :antwort_1, :antwort_2, :antwort_3, :ergebnis)");
    $insert->execute(array('uid' => $_SESSION['id'], 'id' => $id, 'antwort_1' => $antwort_1, 'antwort_2' => $antwort_2, 'antwort_3' => $antwort_3, 'ergebnis' => $antwort_check));
    header("Location: /lernen/themen/rs/lernen.php?thema=" . $thema . "&result=" . $id);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lernen nach Themen &rsaquo; FRS-Portal</title>
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

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" id="nav__main" style="position: relative;">
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
    <!-- <section class="container py-4 text-dark" id="breadcrumbs__main">
        <div class="breadcrumbs__inner">
            <a href="#">Startseite</a> // Lorem // Ipsum
        </div>
    </section> -->
    <div id="scroll"></div>
    <section class="p-5" id="main">
        <div class="container learning__question-container">
            <!-- <p class="header__above" style="color:red">FRS Stettbeck</p> -->
            <div class="text__heading">
                <div class="text__heading-foreground">
                    <h1 class="text-center fw-bold mb-4"><?= $frage['frage'] ?></h1>
                </div>
                <!-- <div class="text__heading-backdrop">FRS</div> -->
            </div>
            <?php if (!isset($_GET['result'])) { ?>
                <form method="post" action="">
                    <input type="hidden" name="new" id="new" value="1">
                    <input type="hidden" name="id" id="id" value="<?= $frage['id'] ?>">
                    <input type="hidden" name="thema" id="thema" value="<?= $frage['thema'] ?>">
                    <div class="learning__question">
                        <div class="row my-5">
                            <div class="col-1 d-flex align-items-center"><input type="checkbox" name="antwort_1" id="antwort_1" value="1"></div>
                            <div class="col d-flex align-items-center"><?= $frage['antwort_1'] ?></div>
                        </div>
                        <div class="row my-5">
                            <div class="col-1 d-flex align-items-center"><input type="checkbox" name="antwort_2" id="antwort_2" value="1"></div>
                            <div class="col d-flex align-items-center"><?= $frage['antwort_2'] ?></div>
                        </div>
                        <div class="row my-5">
                            <div class="col-1 d-flex align-items-center"><input type="checkbox" name="antwort_3" id="antwort_3" value="1"></div>
                            <div class="col d-flex align-items-center"><?= $frage['antwort_3'] ?></div>
                        </div>
                    </div>
                    <!-- Knopf gibt beim ersten Speichern die Lösungen ab -->
                    <!-- wenn Lösungen abgegeben wurden, dann zeigt der Knopf weiter an. -->
                    <hr class="my-5" style="color:transparent">
                    </hr>
                    <div class="learning__question-button">
                        <input class="btn btn-lg btn-primary rounded-0" name="submit" type="submit" value="Lösung anzeigen" />
                    </div>
                </form>
            <?php } else { ?>
                <form>
                    <div class="learning__question">
                        <?php if ($frage['antwort_1_true']) { ?>
                            <div class="row my-5 learning__question-true">
                                <div class="col-1 d-flex align-items-center"><input type="checkbox" disabled <?php if ($result['antwort_1'] == true) echo "checked"; ?>></div>
                                <div class="col d-flex align-items-center"><?= $frage['antwort_1'] ?></div>
                            </div>
                        <?php } else { ?>
                            <div class="row my-5 learning__question-false">
                                <div class="col-1 d-flex align-items-center"><input type="checkbox" disabled <?php if ($result['antwort_1'] == true) echo "checked"; ?>></div>
                                <div class="col d-flex align-items-center"><?= $frage['antwort_1'] ?></div>
                            </div>
                        <?php } ?>
                        <?php if ($frage['antwort_2_true']) { ?>
                            <div class="row my-5 learning__question-true">
                                <div class="col-1 d-flex align-items-center"><input type="checkbox" disabled <?php if ($result['antwort_2'] == true) echo "checked"; ?>></div>
                                <div class="col d-flex align-items-center"><?= $frage['antwort_2'] ?></div>
                            </div>
                        <?php } else { ?>
                            <div class="row my-5 learning__question-false">
                                <div class="col-1 d-flex align-items-center"><input type="checkbox" disabled <?php if ($result['antwort_2'] == true) echo "checked"; ?>></div>
                                <div class="col d-flex align-items-center"><?= $frage['antwort_2'] ?></div>
                            </div>
                        <?php } ?>
                        <?php if ($frage['antwort_3_true']) { ?>
                            <div class="row my-5 learning__question-true">
                                <div class="col-1 d-flex align-items-center"><input type="checkbox" disabled <?php if ($result['antwort_3'] == true) echo "checked"; ?>></div>
                                <div class="col d-flex align-items-center"><?= $frage['antwort_3'] ?></div>
                            </div>
                        <?php } else { ?>
                            <div class="row my-5 learning__question-false">
                                <div class="col-1 d-flex align-items-center"><input type="checkbox" disabled <?php if ($result['antwort_3'] == true) echo "checked"; ?>></div>
                                <div class="col d-flex align-items-center"><?= $frage['antwort_3'] ?></div>
                            </div>
                        <?php } ?>
                    </div>
                    <hr class="my-5" style="color:transparent">
                    </hr>
                    <div class="learning__question-button">
                        <a class="btn btn-lg btn-primary rounded-0" href="/lernen/themen/rs/lernen.php?thema=<?= $frage['thema'] ?>">Weiter</a>
                    </div>
                </form>
            <?php } ?>
        </div>
    </section>
    <div class="mt-4" id="footer__hover">
        Erstellt von Sunny & hypax. Mit <i class="fa-solid fa-heart"></i> und <i class="fa-solid fa-code"></i>.
    </div>
</body>

</html>