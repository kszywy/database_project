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
    <title>Panel pracownika</title>

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

        <h1>Dodaj pracownika</h1>

        <form method="post">

            <label for="addName">Imię: </label>
            <input type="text" name="addName" minlength="3" maxlength="32" pattern="[^\s\da-z][^\s\dA-Z]{1,31}" required>



            <label for="addSurname">Nazwisko: </label>
            <input type="text" name="addSurname" minlength="3" maxlength="32" pattern="[^\s\da-z][^\s\dA-Z]{1,31}" required>



            <label for="addPensja">Pensja: </label>
            <input type="number" name="addPensja" min="2000" max="100000" step="0.01" required>



            <label for="addPesel">Pesel: </label>
            <input type="number" name="addPesel" min="11111111111" max="99999999999" required>



            <label for="addLogin">Login: </label>
            <input type="text" name="addLogin" minlength="5" maxlength="32" required>



            <label for="addPass">Hasło: </label>
            <input type="password" name="addPass" minlength="5" maxlength="32" required>



            <label for="addSelector">Zespół:</label>
            <select name="addSelector" id="addSelector" required>
                <option value=""> Wybierz... </option>
                <option value="NULL">Brak zespołu</option>
                <?php
                $addqst = "SELECT id_zespolu, nazwa_zespolu FROM zespoly";
                $addquery = mysqli_query($connection, $addqst);
                while ($row = mysqli_fetch_array($addquery)) {
                    echo "<option value='" . $row['id_zespolu'] . "'>" . $row['id_zespolu'] . " | " . $row['nazwa_zespolu'] . "</option>";
                }
                ?>

            </select>




            <label for="addSelector2">Stanowisko:</label>
            <select name="addSelector2" id="addSelector2" required>
                <option value=""> Wybierz... </option>
                <?php
                $addqst2 = "SELECT * FROM stanowiska";
                $addquery2 = mysqli_query($connection, $addqst2);
                while ($row = mysqli_fetch_array($addquery2)) {
                    echo "<option value='" . $row['id_stanowiska'] . "'>" . $row['nazwa_stanowiska'] . "</option>";
                }
                ?>

            </select>

            <hr>

            <div class="submit">
                <input type="submit" name="addSubmit" id="addSubmit" value="Dodaj pracownika" class="tab">
            </div>

        </form>

        <br>

        <?php

        if (isset($_POST['addSubmit'])) {
            $name = mysqli_real_escape_string($connection, $_POST['addName']);
            $surname = mysqli_real_escape_string($connection, $_POST['addSurname']);
            $money = mysqli_real_escape_string($connection, $_POST['addPensja']);
            $pesel = mysqli_real_escape_string($connection, $_POST['addPesel']);
            $team = mysqli_real_escape_string($connection, $_POST['addSelector']);
            $position = mysqli_real_escape_string($connection, $_POST['addSelector2']);
            $login = mysqli_real_escape_string($connection, $_POST['addLogin']);
            $pass = mysqli_real_escape_string($connection, $_POST['addPass']);
            $pass = password_hash($pass, PASSWORD_BCRYPT);

            $peselqst = "SELECT pesel FROM pracownicy WHERE pesel='$pesel'";
            $loginqst = "SELECT login FROM konta WHERE login='$login'";

            if (mysqli_num_rows(mysqli_query($connection, $peselqst)) != 0) {
                echo "W bazie danych istnieje już osoba o takim peselu.";
            } else if (mysqli_num_rows(mysqli_query($connection, $loginqst)) != 0) {
                echo "W bazie danych istnieje już użytkownik o takim loginie.";
            } else {
                $addqst3 = "INSERT INTO pracownicy (imie, nazwisko, pesel, pensja, id_zespolu, id_stanowiska)
                 VALUES ('$name', '$surname', '$pesel', $money, $team, $position)";
                $addquery3 = mysqli_query($connection, $addqst3);
                if ($addquery3) {
                    mysqli_close($connection);
                    $connection = mysqli_connect('localhost', 'root', '', 'firma');
                    $tmpqst = "SELECT id_pracownika FROM pracownicy WHERE pesel='$pesel'";
                    $tmpquery = mysqli_query($connection, $tmpqst);
                    $row = mysqli_fetch_array($tmpquery);
                    $newworkerid = $row['id_pracownika'];
                    mysqli_close($connection);
                    $connection = mysqli_connect('localhost', 'root', '', 'firma');
                    $addqst4 = "INSERT INTO konta (id_pracownika, login, haslo) VALUES ($newworkerid, '$login', '$pass')";
                    $addquery4 = mysqli_query($connection, $addqst4);
                    if ($addquery4) {
                        echo "Dodano pracownika do bazy danych,";
                    } else {
                        die("Wystąpił błąd w trakcie dodawania pracownika");
                    }
                }
            }
        }

        ?>


    </div>

    <div class="contentMain">

        <h1>Usuń pracownika</h1>

        <form method="post">
            <label for="delSelector">Wybierz pracownika:</label>
            <select name="delSelector" id="delSelector" required>
                <option value=""> Wybierz... </option>
                <?php
                $delqst = "SELECT id_pracownika, imie, nazwisko FROM pracownicy";
                $delquery = mysqli_query($connection, $delqst);

                while ($row = mysqli_fetch_array($delquery)) {
                    echo "<option value='" . $row['id_pracownika'] . "'>" . $row['id_pracownika'] . " | " . $row['imie'] . " " . $row['nazwisko'] . "</option>";
                }
                ?>
            </select>

            <hr>

            <div class="submit">
                <input type="submit" name="delSubmit" value="Usuń pracownika" class="tab">
            </div>

        </form>

        <br>

        <?php

        if (isset($_POST['delSubmit'])) {
            $value = $_POST['delSelector'];
            $delqst2 = "DELETE FROM konta WHERE id_pracownika=$value; DELETE FROM pracownicy WHERE id_pracownika=$value";
            $delquery = mysqli_multi_query($connection, $delqst2);
            if ($delquery) {
                echo "Pracownik został usunięty z bazy danych.";
            } else {
                die("Wystąpił błąd w trakcie usuwania pracownika.");
            }
        }

        ?>

    </div>


    <div class="contentMain">

        <h1>Edytuj pracownika</h1>


        <form method="post">

            <label for="editID">Wybierz pracownika:</label>
            <select name="editID" id="editID" required>
                <option value=""> Wybierz... </option>
                <?php
                $tmpqst = "SELECT id_pracownika, imie, nazwisko FROM pracownicy";
                $tmpquery = mysqli_query($connection, $tmpqst);

                while ($row = mysqli_fetch_array($tmpquery)) {
                    echo "<option value='" . $row['id_pracownika'] . "'>" . $row['id_pracownika'] . " | " . $row['imie'] . " " . $row['nazwisko'] . "</option>";
                }
                ?>
            </select>



            <label for="editName">Imię: </label>
            <input type="text" name="editName" minlength="3" maxlength="32" pattern="[^\s\da-z][^\s\dA-Z]{1,31}" required>



            <label for="editSurname">Nazwisko: </label>
            <input type="text" name="editSurname" minlength="3" maxlength="32" pattern="[^\s\da-z][^\s\dA-Z]{1,31}" required>



            <label for="editPensja">Pensja: </label>
            <input type="number" name="editPensja" min="2000" max="100000" step="0.01" required>



            <label for="editPesel">Pesel: </label>
            <input type="number" name="editPesel" min="11111111111" max="99999999999" required>



            <label for="editSelector">Zespół:</label>
            <select name="editSelector" id="editSelector" required>
                <option value=""> Wybierz... </option>
                <option value="NULL">Brak zespołu</option>
                <?php
                $editquery = mysqli_query($connection, $addqst);
                while ($row = mysqli_fetch_array($editquery)) {
                    echo "<option value='" . $row['id_zespolu'] . "'>" . $row['id_zespolu'] . " | " . $row['nazwa_zespolu'] . "</option>";
                }
                ?>

            </select>


            <label for="editSelector2">Stanowisko:</label>
            <select name="editSelector2" id="editSelector2" required>
                <option value=""> Wybierz... </option>
                <?php
                $editquery2 = mysqli_query($connection, $addqst2);
                while ($row = mysqli_fetch_array($editquery2)) {
                    echo "<option value='" . $row['id_stanowiska'] . "'>" . $row['nazwa_stanowiska'] . "</option>";
                }
                ?>

            </select>

            <hr>

            <div class="submit">
                <input type="submit" name="editSubmit" id="editSubmit" value="Edytuj pracownika" class="tab">
            </div>

        </form>

        <br>

        <?php

        if (isset($_POST['editSubmit'])) {
            $id = $_POST['editID'];
            $editqst = "SELECT * FROM pracownicy WHERE id_pracownika=$id";
            $editquery = mysqli_query($connection, $editqst);

            if (mysqli_num_rows($editquery) == 1) {
                $name = mysqli_real_escape_string($connection, $_POST['editName']);
                $surname = mysqli_real_escape_string($connection, $_POST['editSurname']);
                $money = mysqli_real_escape_string($connection, $_POST['editPensja']);
                $pesel = mysqli_real_escape_string($connection, $_POST['editPesel']);
                $team = mysqli_real_escape_string($connection, $_POST['editSelector']);
                $position = mysqli_real_escape_string($connection, $_POST['editSelector2']);


                $editqst2 = "UPDATE pracownicy
                        SET imie='$name', nazwisko='$surname', pensja='$money', pesel='$pesel', id_zespolu=$team, id_stanowiska='$position'
                        WHERE id_pracownika=$id";


                $editquery = mysqli_query($connection, $editqst2);

                if ($editquery) {
                    echo "Zaktualizowano bazę danych.";
                } else {
                    echo "Wystąpił problem podczas aktualizowania bazy danych.";
                }
            }
        }

        mysqli_close($connection);

        ?>

    </div>

</body>

</html>