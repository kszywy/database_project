<?php

require("../php/database.php");
require("../php/session.php");
require("../php/logout.php");
require("../php/functions.php");
require("../php/return.php");

?>

<!DOCTYPE HTML>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Wojciech Cioczek" />
    <meta name="description" content="Zadanie projektowe" />
    <title>Projekt aplikacji</title>

    <link rel="shortcut icon" href="../images/xyz.ico" />
    <link rel="stylesheet" href="../styles/style.css" type="text/css" />
    <link rel="stylesheet" href="../styles/pageStyle.css" type="text/css" />
</head>

<body>

    <div class="account">
        <form method="post">
            <label for="logout"></label><input type="submit" value="Wyloguj się" name="logout" id="logout">
            <label for="return"></label><input type="submit" value="< Powrót" name="return" id="return">
        </form>
        <img src="../images/user.png" alt="User" width="64" height="64">
        <br>
        <?php echo $_SESSION['użytkownik'] ?>
    </div>

    <div class="contentMain">

        <h1>Przypisz pracownika do zespołu</h1>

        <form method="post">

            <label for="workerSelector">Wybierz pracownika:</label>
            <select name="workerSelector" id="workerSelector" required>
                <option value="">Wybierz...</option>
                <?php
                $qst = "SELECT imie, nazwisko, id_pracownika FROM pracownicy";
                $query = mysqli_query($connection, $qst);
                while ($row = mysqli_fetch_array($query)) {
                    echo '<option value="' . $row['id_pracownika'] . '">' . $row['id_pracownika'] . ' | ' . $row['imie'] . " " .  $row['nazwisko'] . '</option>';
                }

                ?>
            </select>



            <label for="teamSelector">Wybierz zespół:</label>
            <select name="teamSelector" id="teamSelector" required>
                <option value="">Wybierz...</option>
                <option value="NULL">Brak przypisanego zespołu</option>
                <?php
                $qst2 = "SELECT id_zespolu, nazwa_zespolu FROM zespoly";
                $query2 = mysqli_query($connection, $qst2);
                while ($row = mysqli_fetch_array($query2)) {
                    echo '<option value="' . $row['id_zespolu'] . '">' . $row['id_zespolu'] . ' | ' . $row['nazwa_zespolu'] . '</option>';
                }

                ?>
            </select>


            <hr>

            <div class="submit">
                <input type="submit" value="Akceptuj" class="tab" name="submit1">
            </div>


        </form>

        <br>

        <?php

        if (isset($_POST['submit1'])) {
            $idteam = mysqli_real_escape_string($connection, $_POST['teamSelector']);
            $idworker = mysqli_real_escape_string($connection, $_POST['workerSelector']);
            $qst3 = "UPDATE pracownicy SET id_zespolu=$idteam WHERE id_pracownika=$idworker";
            $query3 = mysqli_query($connection, $qst3);
            if (mysqli_affected_rows($connection) == 1)
                echo "Przypisano pracownika do zespołu.";
            else
                die("Wystąpił błąd w trakcie przypisywania pracownika.");
        }

        ?>

    </div>

    <div class="contentMain">

        <h1>Przypisz zespół do projektu</h1>

        <form method="post">

            <label for="teamSelector2">Wybierz zespół:</label>
            <select name="teamSelector2" id="teamSelector2" required>
                <option value="">Wybierz...</option>
                <?php
                $qst4 = "SELECT id_zespolu, nazwa_zespolu FROM zespoly";
                $query4 = mysqli_query($connection, $qst4);
                while ($row = mysqli_fetch_array($query4)) {
                    echo '<option value="' . $row['id_zespolu'] . '">' . $row['id_zespolu'] . ' | ' . $row['nazwa_zespolu'] . '</option>';
                }

                ?>
            </select>



            <label for="projectSelector">Wybierz projekt:</label>
            <select name="projectSelector" id="projectSelector" required>
                <option value="">Wybierz...</option>
                <option value="NULL">Brak przypisanego projektu</option>
                <?php
                $qst5 = "SELECT id_projektu, nazwa_projektu FROM projekty";
                $query5 = mysqli_query($connection, $qst5);
                while ($row = mysqli_fetch_array($query5)) {
                    echo '<option value="' . $row['id_projektu'] . '">' . $row['id_projektu'] . ' | ' . $row['nazwa_projektu'] . '</option>';
                }

                ?>
            </select>


            <hr>

            <div class="submit">
                <input type="submit" value="Akceptuj" class="tab" name="submit2">
            </div>

        </form>

        <br>

        <?php

            if (isset($_POST['submit2'])) {
                $idteam = mysqli_real_escape_string($connection, $_POST['teamSelector2']);
                $idproject = mysqli_real_escape_string($connection, $_POST['projectSelector']);
                $qst6 = "UPDATE zespoly SET id_projektu=$idproject WHERE id_zespolu=$idteam";
                $query6 = mysqli_query($connection, $qst6);
                if (mysqli_affected_rows($connection) == 1)
                    echo "Przypisano zespół do projektu.";
                else
                    die("Wystąpił błąd w trakcie przypisywania zespołu.");
            }

            ?>

    </div>

    <div class="contentMain">

        <h1>Przypisz klienta do projektu</h1>

        <form method="post">

            <label for="clientSelector">Wybierz klienta:</label>
            <select name="clientSelector" id="clientSelector" required>
                <option value="">Wybierz...</option>
                <?php
                $qst7 = "SELECT id_klienta, nazwa FROM klienci";
                $query7 = mysqli_query($connection, $qst7);
                while ($row = mysqli_fetch_array($query7)) {
                    echo '<option value="' . $row['id_klienta'] . '">' . $row['id_klienta'] . ' | ' . $row['nazwa'] . '</option>';
                }

                ?>
            </select>



            <label for="projectSelector2">Wybierz projekt:</label>
            <select name="projectSelector2" id="teamSelector2" required>
                <option value="">Wybierz...</option>
                <?php
                $qst8 = "SELECT id_projektu, nazwa_projektu FROM projekty";
                $query8 = mysqli_query($connection, $qst8);
                while ($row = mysqli_fetch_array($query8)) {
                    echo '<option value="' . $row['id_projektu'] . '">' . $row['id_projektu'] . ' | ' . $row['nazwa_projektu'] . '</option>';
                }

                ?>
            </select>


            <hr>

            <div class="submit">
                <input type="submit" value="Akceptuj" class="tab" name="submit3">
            </div>

        </form>

        <br>

        <?php

            if (isset($_POST['submit3'])) {
                $idclient = mysqli_real_escape_string($connection, $_POST['clientSelector']);
                $idproject = mysqli_real_escape_string($connection, $_POST['projectSelector2']);
                $qst9 = "UPDATE projekty SET id_klienta=$idclient WHERE id_projektu=$idproject";
                $query9 = mysqli_query($connection, $qst9);
                if (mysqli_affected_rows($connection) == 1)
                    echo "Przypisano klienta do projektu.";
                else
                    die("Wystąpił błąd w trakcie przypisywania klienta.");
            }

            ?>

    </div>

</body>

</html>