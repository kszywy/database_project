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
    <title>Panel klienta</title>

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

        <h1>Dodaj klienta</h1>

        <form method="post">

            <label for="addname">Nazwa klienta: </label>
            <input type="text" name="addName" minlength="5" maxlength="64" required>



            <label for="addPlace">Miejscowość: </label>
            <input type="text" name="addPlace" pattern="[^\s\da-z][^\d]{1,31}" required>



            <label for="addStreet">Ulica: </label>
            <input type="text" name="addStreet" pattern="[^\s\da-z][^\d]{1,31}" required>



            <label for="addHouse">Numer domu: </label>
            <input type="text" name="addHouse" maxlength="8" required>



            <label for="addEmail">Email: </label>
            <input type="email" name="addEmail" minlength="5" maxlength="32" required>



            <hr>

            <div class="submit">
                <input type="submit" name="addSubmit" id="addSubmit" value="Dodaj" class="tab">
            </div>

        </form>

        <br>

        <?php

        if (isset($_POST['addSubmit'])) {

            $name = mysqli_real_escape_string($connection, $_POST['addName']);
            $place = mysqli_real_escape_string($connection, $_POST['addPlace']);
            $street = mysqli_real_escape_string($connection, $_POST['addStreet']);
            $house = mysqli_real_escape_string($connection, $_POST['addHouse']);
            $email = mysqli_real_escape_string($connection, $_POST['addEmail']);


            $addqst = "INSERT INTO klienci (nazwa, miejscowosc, ulica, numer_domu, email)
                VALUES ('$name', '$place', '$street', '$house', '$email')";

            $addquery = mysqli_query($connection, $addqst);
            if (mysqli_affected_rows($connection) == 0) {
                die("Wystąpił błąd w trakcie dodawania klienta.");
            } else {
                echo "Klient został dodany do bazy danych.";
            }
        }

        ?>


    </div>

    <div class="contentMain">

        <h1>Usuń klienta</h1>

        <form method="post">
            <label for="delSelector">Wybierz klienta:</label>
            <select name="delSelector" id="delSelector" required>
                <option value=""> Wybierz... </option>
                <?php
                $delqst = "SELECT id_klienta, nazwa FROM klienci";
                $delquery = mysqli_query($connection, $delqst);

                while ($row = mysqli_fetch_array($delquery)) {
                    echo "<option value='" . $row['id_klienta'] . "'>" . $row['id_klienta'] . " | " . $row['nazwa'] . "</option>";
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
            $delqst2 = "DELETE FROM klienci WHERE id_klienta=$value";
            $delquery2 = mysqli_query($connection, $delqst2);
            if (mysqli_affected_rows($connection) == 0) {
                die("Wystąpił błąd w trakcie usuwania klienta.");
            } else {
                echo "Klient został usunięty z bazy danych.";
            }
        }

        ?>

    </div>


    <div class="contentMain">

        <h1>Edytuj klienta</h1>


        <form method="post">

            <label for="editID">Wybierz klienta:</label>
            <select name="editID" id="editID" required>
                <option value=""> Wybierz... </option>
                <?php
                $tmpqst = "SELECT id_klienta, nazwa FROM klienci";
                $tmpquery = mysqli_query($connection, $tmpqst);

                while ($row = mysqli_fetch_array($tmpquery)) {
                    echo "<option value='" . $row['id_klienta'] . "'>" . $row['id_klienta'] . " | " . $row['nazwa'] . "</option>";
                }
                ?>
            </select>



            <label for="editName">Nazwa klienta: </label>
            <input type="text" name="editName" minlength="5" maxlength="64" required>



            <label for="editPlace">Miejscowość: </label>
            <input type="text" name="editPlace" pattern="[^\s\da-z][^\d]{1,63}" required>



            <label for="editStreet">Ulica: </label>
            <input type="text" name="editStreet" pattern="[^\s\da-z][^\d]{1,31}" required>



            <label for="editHouse">Numer domu: </label>
            <input type="text" name="editHouse" maxlength="8" required>



            <label for="editName">Email: </label>
            <input type="email" name="editEmail" minlength="5" maxlength="32" required>



            <hr id="stylishHR">

            <div class="submit">
                <input type="submit" name="editSubmit" id="editSubmit" value="Edytuj" class="tab">
            </div>

        </form>

        <br>

        <?php

        if (isset($_POST['editSubmit'])) {
            $id = mysqli_real_escape_string($connection, $_POST['editID']);
            $editqst = "SELECT * FROM klienci WHERE id_klienta=$id";
            $editquery = mysqli_query($connection, $editqst);

            if (mysqli_num_rows($editquery) == 1) {

                $name = mysqli_real_escape_string($connection, $_POST['editName']);
                $place = mysqli_real_escape_string($connection, $_POST['editPlace']);
                $street = mysqli_real_escape_string($connection, $_POST['editStreet']);
                $house = mysqli_real_escape_string($connection, $_POST['editHouse']);
                $email = mysqli_real_escape_string($connection, $_POST['editEmail']);


                $editqst2 = "UPDATE klienci
                        SET nazwa='$name', miejscowosc='$place', ulica='$street',
                        numer_domu='$house', email='$email'
                        WHERE id_klienta=$id";

                $editquery = mysqli_query($connection, $editqst2);

                if ($editquery) {
                    echo "Zaktualizowano bazę danych.";
                } else {
                    die("Wystąpił problem podczas aktualizowania bazy danych.");
                }
            }
        }

        mysqli_close($connection);

        ?>

    </div>

</body>

</html>