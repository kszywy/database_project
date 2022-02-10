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
    <title>Panel spotkania</title>

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

        <h1>Dodaj spotkanie</h1>

        <form method="post">

            <label for="addSelector">Wybierz klienta:</label>
            <select name="addSelector" id="addSelector" required>
                <option value=""> Wybierz... </option>
                <?php
                $addqst = "SELECT id_klienta, nazwa FROM klienci";
                $addquery = mysqli_query($connection, $addqst);
                while ($row = mysqli_fetch_array($addquery)) {
                    echo "<option value='" . $row['id_klienta'] . "'>" . $row['id_klienta'] . " | " . $row['nazwa'] . "</option>";
                }
                ?>

            </select>

            <hr>

            <div class="submit">
                <input type="submit" name="addSubmitSelector" id="addSubmitSelector" value="Wybierz" class="tab">
            </div>



        </form>

        <br>

        <?php

        if (isset($_POST['addSubmitSelector'])) {

            $client = mysqli_real_escape_string($connection, $_POST['addSelector']);

            echo '<form method="post">';

            echo '<label for="addClient" style="display:none;">ID klienta: </label>';
            echo '<input type="number" name="addClient" value="' . $client . '" readonly style="display:none;">';

            echo '';

            echo '<label for="addDate">Data spotkania: </label>';
            echo '<input type="datetime-local" name="addDate" class="addDate" required>';

            echo '';


            echo '<label for="addSelector2">Wybierz przypisany projekt:</label>';
            echo '<select name="addSelector2" id="addSelector2" required>';
            echo    '<option value=""> Wybierz... </option>';
            $addqst2 = "SELECT id_projektu, nazwa_projektu FROM projekty WHERE id_klienta=$client";
            $addquery2 = mysqli_query($connection, $addqst2);
            while ($row = mysqli_fetch_array($addquery2)) {
                echo "<option value='" . $row['id_projektu'] . "'>" . $row['id_projektu'] . " | " . $row['nazwa_projektu'] . "</option>";
            }

            echo '</select>';

            echo '';

            echo '<hr>';

            echo ' <div class="submit">';
            echo '<input type="submit" name="addSubmit" id="addSubmit" value="Dodaj" class="tab">';
            echo '</div>';

            echo '</form>';
        }


        if (isset($_POST['addSubmit'])) {

            $idproj = mysqli_real_escape_string($connection, $_POST['addSelector2']);
            $date = mysqli_real_escape_string($connection, $_POST['addDate']);
            $client = mysqli_real_escape_string($connection, $_POST['addClient']);


            $addqst2 = "INSERT INTO spotkania (id_klienta, id_projektu, data)
                    VALUES ($client, $idproj, '$date')";

            $addquery2 = mysqli_query($connection, $addqst2);
            if (mysqli_affected_rows($connection) == 0) {
                die("Wystąpił błąd w trakcie dodawania spotkania.");
            } else {
                echo "Spotkanie zostało dodane do bazy danych.";
            }
        }

        ?>


    </div>

    <div class="contentMain">

        <h1>Usuń spotkanie</h1>

        <form method="post">
            <label for="delSelector">Wybierz ID spotkania:</label>
            <select name="delSelector" id="delSelector" required>
                <option value=""> Wybierz... </option>
                <?php
                $delqst = "SELECT id_spotkania FROM spotkania";
                $delquery = mysqli_query($connection, $delqst);

                while ($row = mysqli_fetch_array($delquery)) {
                    echo "<option value='" . $row['id_spotkania'] . "'>" . $row['id_spotkania'] . "</option>";
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
            $value = $_POST['delSelector'];
            $delqst2 = "DELETE FROM spotkania WHERE id_spotkania=$value";
            $delquery2 = mysqli_query($connection, $delqst2);
            if (mysqli_affected_rows($connection) == 0) {
                die("Wystąpił błąd w trakcie usuwania spotkania.");
            } else {
                echo "Spotkanie zostało usunięte z bazy danych.";
            }
        }

        ?>

    </div>


    <div class="contentMain">

        <h1>Edytuj spotkanie</h1>

        <h3>UWAGA: Niemożliwa jest edycja klienta przypisanego do spotkania</h2>


            <form method="post">

                <label for="editID">Wybierz ID spotkania:</label>
                <select name="editID" id="editiD" required>
                    <option value=""> Wybierz...</option>
                    <?php
                    $tmpqst = "SELECT id_spotkania FROM spotkania";
                    $tmpquery = mysqli_query($connection, $tmpqst);

                    while ($row = mysqli_fetch_array($tmpquery)) {
                        echo "<option value='" . $row['id_spotkania'] . "'>" . $row['id_spotkania'] . "</option>";
                    }
                    ?>
                </select>



                <hr id="stylishHR">

                <div class="submit">
                    <input type="submit" name="editSubmit" id="editSubmit" value="Wyświetl" class="tab">
                </div>

            </form>

            <br>

            <?php

            if (isset($_POST['editSubmit'])) {
                $id = $_POST['editID'];
                $editqst = "SELECT projekty.id_projektu, projekty.nazwa_projektu FROM projekty, spotkania WHERE id_spotkania=$id";
                $editquery = mysqli_query($connection, $editqst);

                echo '<form method="post">';

                echo '<label for="editID2" style="display:none;">ID spotkania: </label>';
                echo '<input type="number" name="editID2" value="' . $id . '" readonly style="display: none;">';

                echo '<label for="editDate">Data spotkania: </label>';
                echo '<input type="datetime-local" name="editDate" class="addDate" required>';

                echo '';


                echo '<label for="editSelector">Wybierz przypisany projekt:</label>';
                echo '<select name="editSelector" id="editSelector" required>';
                echo    '<option value=""> Wybierz... </option>';
                while ($row = mysqli_fetch_array($editquery)) {
                    echo "<option value='" . $row['id_projektu'] . "'>" . $row['id_projektu'] . " | " . $row['nazwa_projektu'] . "</option>";
                }

                echo '</select>';

                echo '';

                echo '<hr>';

                echo ' <div class="submit">';
                echo '<input type="submit" name="editSubmit2" id="editSubmit2" value="Edytuj" class="tab">';
                echo '</div>';

                echo '</form>';
            }

            ?>

            <br>

            <?php

            if (isset($_POST['editSubmit2'])) {;

                $date = mysqli_real_escape_string($connection, $_POST['editDate']);
                $idproj = $_POST['editSelector'];
                $id = $_POST['editID2'];

                $editqst2 = "UPDATE spotkania
                        SET id_projektu=$idproj, data='$date'
                        WHERE id_spotkania=$id";

                $editquery2 = mysqli_query($connection, $editqst2);

                if ($editquery2) {
                    echo "Zaktualizowano bazę danych.";
                } else {
                    echo "Wystąpił problem podczas aktualizowania bazy danych.";
                }
            }

            mysqli_close($connection);

            ?>

    </div>

</body>

</html>