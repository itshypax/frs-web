<?php
session_start();
require_once '../../config/config.php';
$pdo = new PDO('mysql:host=' . MYSQL_ROOT . ';dbname=' . MYSQL_DB, MYSQL_USER, MYSQL_PASS);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerübersicht &rsaquo; FRS-Portal</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../../src/css/main.min.css" />
    <link rel="stylesheet" href="../../src/fonts/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="../../src/fonts/ptsans/css/all.min.css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../src/assets/bootstrap-5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/assets/datatables/datatables.min.css">
    <script src="../../src/assets/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
    <script src="../../src/assets/jquery/jquery-3.7.0.min.js"></script>
    <script src="../../src/assets/datatables/datatables.min.js"></script>
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
                    <h1 class="text-center fw-bold mb-4">Benutzerübersicht</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-2"></div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped" id="userTable">
                                <thead>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name (Benutzername)</th>
                                    <th scope="col">Rolle</th>
                                    <th scope="col">Angelegt am</th>
                                    <th scope="col"></th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = 'SELECT * FROM users';
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $datetime = new DateTime($row['created_at']);
                                        $date = $datetime->format('d.m.Y | H:i');
                                        echo "<tr>";
                                        echo "<td >" . $row['id'] . "</td>";
                                        echo "<td>" . $row['fullname'] .  " (<strong>" . $row['username'] . "</strong>)</td>";
                                        echo "<td></td>";
                                        echo "<td><span style='display:none'>" . $row['created_at'] . "</span>" . $date . "</td>";
                                        echo "<td><a href='/admin/users/edit.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Bearbeiten</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
        </div>
    </section>
    <div class="mt-4" id="footer__hover">
        Erstellt von Sunny & hypax. Mit <i class="fa-solid fa-heart"></i> und <i class="fa-solid fa-code"></i>.
    </div>
    <script src="/components/js/show_password.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#userTable').DataTable({
                stateSave: true,
                paging: true,
                lengthMenu: [5, 10, 20],
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }],
                language: {
                    "decimal": "",
                    "emptyTable": "Keine Daten vorhanden",
                    "info": "Zeige _START_ bis _END_  | Gesamt: _TOTAL_",
                    "infoEmpty": "Keine Daten verfügbar",
                    "infoFiltered": "| Gefiltert von _MAX_ Benutzern",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "_MENU_ Benutzer pro Seite anzeigen",
                    "loadingRecords": "Lade...",
                    "processing": "Verarbeite...",
                    "search": "Benutzer suchen:",
                    "zeroRecords": "Keine Einträge gefunden",
                    "paginate": {
                        "first": "Erste",
                        "last": "Letzte",
                        "next": "Nächste",
                        "previous": "Vorherige"
                    },
                    "aria": {
                        "sortAscending": ": aktivieren, um Spalte aufsteigend zu sortieren",
                        "sortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
                    }
                }
            });
        });
    </script>
</body>

</html>