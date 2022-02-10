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
    <title>Panel projektu</title>

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

    <?php

    $addqst = "SELECT id_klienta, nazwa FROM klienci";
    $addquery = mysqli_query($connection, $addqst);

    if (!$addquery) {
        die("Wystąpił błąd w trakcie łączenia się z bazą danych");
    }

    ?>

    <div class="contentMain">

        <h1>Dodaj projekt</h1>

        <form method="post">

            <label for="name">Nazwa projektu: </label>
            <input type="text" name="addName" minlength="5" maxlength="32" required>


            <label for="addDate2">Data rozpoczęcia: </label>
            <input type="date" name="addDate1" class="addDate" required>


            <label for="addDate2">Data zakończenia: </label>
            <input type="date" name="addDate2" class="addDate" required>


            <label for="addSubpages">Liczba podstron: </label>
            <input type="number" name="addSubpages" min="1" max="1000" required>


            <label class="checkWrap">Ekspresowy czas wykonania
                <input type="checkbox" name="addExpress">
                <span class="checkField"></span>
            </label>


            <label class="checkWrap">Projekt graficzny
                <input type="checkbox" name="addGp">
                <span class="checkField"></span>
            </label>


            <label class="checkWrap">System CMS
                <input type="checkbox" name="addCms">
                <span class="checkField"></span>
            </label>


            <label for="addSelector">Wybierz klienta:</label>
            <select name="addSelector" id="addSelector" required>
                <option value=""> Wybierz... </option>
                <?php
                while ($row = mysqli_fetch_array($addquery)) {
                    echo "<option value='" . $row['id_klienta'] . "'>" . $row['id_klienta'] . " | " . $row['nazwa'] . "</option>";
                }
                ?>

            </select>



            <hr>

            <div class="submit">
                <input type="submit" name="addSubmit" id="addSubmit" value="Dodaj" class="tab">
            </div>

        </form>

        <br>

        <?php

        if (isset($_POST['addSubmit'])) {
            $gp;
            $express;
            $cms;

            $name = mysqli_real_escape_string($connection, $_POST['addName']);
            $date1 = mysqli_real_escape_string($connection, $_POST['addDate1']);
            $date2 = mysqli_real_escape_string($connection, $_POST['addDate2']);
            $subpages = mysqli_real_escape_string($connection, $_POST['addSubpages']);
            $selector = mysqli_real_escape_string($connection, $_POST['addSelector']);

            if (isset($_POST['addGp'])) {
                $gp = mysqli_real_escape_string($connection, 1);
            } else {
                $gp = mysqli_real_escape_string($connection, 0);
            }

            if (isset($_POST['addCms'])) {
                $cms = mysqli_real_escape_string($connection, 1);
            } else {
                $cms = mysqli_real_escape_string($connection, 0);
            }

            if (isset($_POST['addExpress'])) {
                $express = mysqli_real_escape_string($connection, 1);
            } else {
                $express = mysqli_real_escape_string($connection, 0);
            }

            $addqst2 = "INSERT INTO projekty (id_klienta, nazwa_projektu, data_rozpoczecia, data_zakonczenia, liczba_podstron, graficzny, cms, ekspresowy_czas_wykonania)
                VALUES ($selector, '$name', '$date1', '$date2', $subpages, $gp, $cms, $express)";


            $addquery2 = mysqli_query($connection, $addqst2);
            if (mysqli_affected_rows($connection) == 0) {
                die("Wystąpił błąd w trakcie dodawania projektu.");
            } else {
                echo "Projekt został dodany do bazy danych.";
            }
        }

        ?>


    </div>

    <div class="contentMain">

        <h1>Usuń projekt</h1>

        <form method="post">
            <label for="delSelector">Wybierz projekt:</label>
            <select name="delSelector" id="delSelector" required>
                <option value=""> Wybierz... </option>
                <?php
                $delqst = "SELECT id_projektu, nazwa_projektu FROM projekty";
                $delquery = mysqli_query($connection, $delqst);

                while ($row = mysqli_fetch_array($delquery)) {
                    echo "<option value='" . $row['id_projektu'] . "'>" . $row['id_projektu'] . ' | ' . $row['nazwa_projektu'] . "</option>";
                }
                ?>
            </select>

            <hr>

            <div class="submit">
                <input type="submit" name="delSubmit" value="Usuń" class="tab">
            </div>

        </form>

        <br>

        <?php

        if (isset($_POST['delSubmit'])) {
            $value = mysqli_real_escape_string($connection, $_POST['delSelector']);
            $delqst2 = "DELETE FROM projekty WHERE id_projektu=$value";
            $delquery2 = mysqli_query($connection, $delqst2);
            if (mysqli_affected_rows($connection) == 0) {
                die("Wystąpił błąd w trakcie usuwania projektu.");
            } else {
                echo "Projekt został usunięty z bazy danych.";
            }
        }

        ?>

    </div>


    <div class="contentMain">

        <h1>Edytuj projekt</h1>


        <form method="post">

            <label for="editID">ID projektu</label>
            <select name="editID" id="editID" required>
                <option value="">Wybierz...</option>
                <?php
                $idqst = "SELECT id_projektu, nazwa_projektu FROM projekty";
                $idquery = mysqli_query($connection, $idqst);
                while ($row = mysqli_fetch_array($idquery)) {
                    echo '<option value="' . $row['id_projektu'] . '">' . $row['id_projektu'] .  ' | ' . $row['nazwa_projektu'] . '</option>';
                }
                ?>
            </select>



            <label for="editName">Nazwa projektu: </label>
            <input type="text" name="editName" required>



            <label for="editDate1">Data rozpoczęcia: </label>
            <input type="date" name="editDate1" class="editDate" required>



            <label for="editDate2">Data zakończenia: </label>
            <input type="date" name="editDate2" class="editDate" required>



            <label for="editSubpages">Liczba podstron: </label>
            <input type="number" name="editSubpages" min="1" max="1000" required>



            <label class="checkWrap">Ekspresowy czas wykonania
                <input type="checkbox" name="editExpress">
                <span class="checkField"></span>
            </label>



            <label class="checkWrap">Projekt graficzny
                <input type="checkbox" name="editGp">
                <span class="checkField"></span>
            </label>



            <label class="checkWrap">System CMS
                <input type="checkbox" name="editCms">
                <span class="checkField"></span>
            </label>



            <label for="editSelector">Wybierz klienta:</label>
            <select name="editSelector" id="editSelector" required>
                <option value=""> Wybierz... </option>
                <?php
                $addqst = "SELECT id_klienta, nazwa FROM klienci";
                $clientquery = mysqli_query($connection, $addqst);
                while ($row = mysqli_fetch_array($clientquery)) {
                    echo "<option value='" . $row['id_klienta'] . "'>" . $row['id_klienta'] . " | " . $row['nazwa'] . "</option>";
                }
                ?>

            </select>



            <hr id="stylishHR">

            <div class="submit">
                <input type="submit" name="editSubmit" id="editSubmit" value="Edytuj" class="tab">
            </div>

        </form>

        <br>

        <?php

        if (isset($_POST['editSubmit'])) {
            $id = mysqli_real_escape_string($connection, $_POST['editID']);
            $editqst = "SELECT * FROM projekty WHERE id_projektu=$id";
            $editquery = mysqli_query($connection, $editqst);

            if (mysqli_num_rows($editquery) == 1) {
                $gp;
                $express;
                $cms;

                $name = mysqli_real_escape_string($connection, $_POST['editName']);
                $date1 = mysqli_real_escape_string($connection, $_POST['editDate1']);
                $date2 = mysqli_real_escape_string($connection, $_POST['editDate2']);
                $subpages = mysqli_real_escape_string($connection, $_POST['editSubpages']);
                $selector = mysqli_real_escape_string($connection, $_POST['editSelector']);

                if (isset($_POST['editGp'])) {
                    $gp = mysqli_real_escape_string($connection, 1);
                } else {
                    $gp = mysqli_real_escape_string($connection, 0);
                }

                if (isset($_POST['editCms'])) {
                    $cms = mysqli_real_escape_string($connection, 1);
                } else {
                    $cms = mysqli_real_escape_string($connection, 0);
                }

                if (isset($_POST['editExpress'])) {
                    $express = mysqli_real_escape_string($connection, 1);
                } else {
                    $express = mysqli_real_escape_string($connection, 0);
                }

                $editqst2 = "UPDATE projekty
                        SET id_klienta=$selector, nazwa_projektu='$name', data_rozpoczecia='$date1', data_zakonczenia='$date2',
                        liczba_podstron=$subpages, graficzny=$gp, cms=$cms, ekspresowy_czas_wykonania=$express
                        WHERE id_projektu=$id";


                $editquery = mysqli_query($connection, $editqst2);

                if ($editquery) {
                    echo "Zaktualizowano bazę danych.";
                } else {
                    echo "Wystąpił problem podczas aktualizowania bazy danych.";
                }
            } else {
                echo "Nie znaleziono projektu o podanym ID.";
            }
        }

        mysqli_close($connection);

        ?>

    </div>



    <script>
        function compareDates(e, tab) {
            const date1 = new Date(tab[0].value);
            const date2 = new Date(tab[1].value);

            if (date1 > date2) {
                e.preventDefault();
                alert("Pierwsza data powinna być mniejsza od drugiej!");
            } else if (date1.toString() === date2.toString()) {
                e.preventDefault();
                alert("Pierwsza data powinna być mniejsza od drugiej!");
            }
        }

        const dates1 = document.getElementsByClassName('addDate');
        const dates2 = document.getElementsByClassName('editDate');

        document.getElementById('addSubmit').addEventListener('click', function(e) {
            compareDates(e, dates1);
        }, false);

        document.getElementById('editSubmit').addEventListener('click', function(e) {
            compareDates(e, dates2);
        }, false);
    </script>
</body>

</html>