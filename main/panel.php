<?php

require("../php/database.php");
require("../php/session.php");
require("../php/logout.php");

?>

<!DOCTYPE HTML>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Wojciech Cioczek" />
    <meta name="description" content="Zadanie projektowe" />
    <title>Panel główny</title>

    <link rel="shortcut icon" href="../images/xyz.ico" />
    <link rel="stylesheet" href="../styles/style.css" type="text/css" />
    <link rel="stylesheet" href="../styles/tileStyle.css" type="text/css" />
</head>

<body>

    <div class="account">
        <form method="post">
            <label for="logout"></label><input type="submit" value="Wyloguj się" name="logout" id="logout">
            <label for="return"></label><input type="submit" value="< Powrót" name="return" id="return" disabled>
        </form>
        <img src="../images/user.png" alt="User" width="64" height="64">
        <br>
        <?php echo $_SESSION['użytkownik'] ?>
    </div>

    <?php

        if($_SESSION['użytkownik'] == "admin"){
            echo '
            <div id="myadmin">
            <a href="http://localhost/phpmyadmin/db_structure.php?server=1&db=firma" target="_blank">
            <br><br><h3>Przejdź do witryny phpmyadmin</h3>
            <span class="linkSpanner"></span>
            </a>
            </div>';
        }

    ?>

    <div id="chpasswd">
        <h3>Zmień swoje hasło</h3>
        <form method="post">
            <label for="passchange">
                <input type="password" name="passchange" required>
            </label>
            <input type="submit" value="Zmień hasło" name="submitPass" class="tab">
        </form>

        <?php
            if (isset($_POST['submitPass'])){
                $chpass = mysqli_real_escape_string($connection, $_POST['passchange']);
                $chpass = password_hash($chpass, PASSWORD_BCRYPT);
                $login = $_SESSION['użytkownik'];
                $passqst = "UPDATE konta SET haslo='$chpass' WHERE login='$login'";
                echo $passqst;
                $passquery = mysqli_query($connection, $passqst);
                if ($passquery){
                    $_SESSION =  array();
                    session_destroy();
                    header("Location: ../main/login.php");
                }else{
                    die("Wystąpił błąd. Spróbuj później.");
                }
            }
        ?>
    </div>

    <div class="content">

        <h1>Wyświetl raport dotyczący:</h1>

        <div class="tile1">
            <a href="../tiles/raportProjects.php">
                <div class="text">Projektów</div>
                <span class="linkSpanner">
                </span>
            </a>
        </div>

        <div class="tile1">
            <a href="../tiles/raportProject.php">
                <div class="text">Konkretnego projektu</div>
                <span class="linkSpanner">
                </span>
            </a>
        </div>

        <div class="tile1">
            <a href="../tiles/raportProjectTime.php">
                <div class="text">Projektów bieżących, przyszłych i archiwalnych</div>
                <span class="linkSpanner">
                </span>
            </a>
        </div>

        <div class="tile1">
            <a href="../tiles/raportClients.php">
                <div class="text">Klientów</div>
                <span class="linkSpanner">
                </span>
            </a>
        </div>

        <div class="tile1">
            <a href="../tiles/raportClient.php">
                <div class="text">Konkretnego klienta</div>
                <span class="linkSpanner">
                </span>
            </a>
        </div>

        <div class="tile1">
            <a href="../tiles/raportMeetings.php">
                <div class="text">Spotkań z klientami</div>
                <span class="linkSpanner">
                </span>
            </a>
        </div>

        <div class="tile1">
            <a href="../tiles/raportWorkers.php">
                <div class="text">Pracowników</div>
                <span class="linkSpanner">
                </span>
            </a>
        </div>

        <h1>Przypisz:</h1>

        <div class="tile2">
            <a href="../tiles/workerToTeam.php">
                <div class="text">Pracownika do zespołu<br>Zespół do projektu<br>Klienta do projektu</div>
                <span class="linkSpanner">
                </span>
            </a>
        </div>

        <h1>Edytuj/dodaj/usuń:</h1>

        <div class="tile3">
            <a href="../tiles/editProject.php">
                <div class="text">Projekt</div>
                <span class="linkSpanner">
                </span>
            </a>
        </div>

        <div class="tile3">
            <a href="../tiles/editTeam.php">
                <div class="text">Zespół</div>
                <span class="linkSpanner">
                </span>
            </a>
        </div>

        <div class="tile3">
            <a href="../tiles/editWorker.php">
                <div class="text">Pracownik</div>
                <span class="linkSpanner">
                </span>
            </a>
        </div>

        <div class="tile3">
            <a href="../tiles/editMeeting.php">
                <div class="text">Spotkanie</div>
                <span class="linkSpanner">
                </span>
            </a>
        </div>

        <div class="tile3">
            <a href="../tiles/editClient.php">
                <div class="text">Klient</div>
                <span class="linkSpanner">
                </span>
            </a>
        </div>

    </div>

    <script>
        let el = document.getElementById('chpasswd');
        el.addEventListener("click", function(){
            el.style.bottom="-2%";
            el.style.cursor="default";
        }, false);
    </script>

</body>

</html>