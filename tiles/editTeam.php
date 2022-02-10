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
    <title>Panel zespołu</title>

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

    $addqst = "SELECT id_projektu, nazwa_projektu FROM projekty";
    $addquery = mysqli_query($connection, $addqst);

    if (!$addquery) {
        die("Wystąpił błąd w trakcie łączenia się z bazą danych");
    }

    ?>

    <div class="contentMain">

        <h1>Dodaj zespół</h1>

        <form method="post">

            <label for="addName">Nazwa zespołu: </label>
            <input type="text" name="addName" minlength="5" maxlength="16" required>


            <label for="addSelector">Wybierz przypisany projekt:</label>
            <select name="addSelector" id="addSelector" required>
                <option value=""> Wybierz... </option>
                <option value="NULL"> Brak projektu </option>
                <?php
                while ($row = mysqli_fetch_array($addquery)) {
                    echo "<option value='" . $row['id_projektu'] . "'>" . $row['id_projektu'] . " | " . $row['nazwa_projektu'] . "</option>";
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
            $name = mysqli_real_escape_string($connection, $_POST['addName']);
            $id = $_POST['addSelector'];

            $addqst2 = "INSERT INTO zespoly (nazwa_zespolu, id_projektu)
                VALUES ('$name', $id)";


            $addquery2 = mysqli_query($connection, $addqst2);
            if (mysqli_affected_rows($connection) == 0) {
                die("Wystąpił błąd w trakcie dodawania zepołu.");
            } else {
                echo "Zespół został dodany do bazy danych.";
            }
        }

        ?>


    </div>

    <div class="contentMain">

        <h1>Usuń zespół</h1>

        <form method="post">
            <label for="delSelector">Wybierz zespół:</label>
            <select name="delSelector" id="delSelector" required>
                <option value=""> Wybierz... </option>
                <?php
                $delqst = "SELECT id_zespolu, nazwa_zespolu FROM zespoly";
                $delquery = mysqli_query($connection, $delqst);

                while ($row = mysqli_fetch_array($delquery)) {
                    echo "<option value='" . $row['id_zespolu'] . "'>" . $row['id_zespolu'] . '  | ' . $row['nazwa_zespolu'] . "</option>";
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
            $delqst2 = "DELETE FROM zespoly WHERE id_zespolu=$value";
            $delquery2 = mysqli_query($connection, $delqst2);
            if (mysqli_affected_rows($connection) == 0) {
                die("Wystąpił błąd w trakcie usuwania zespołu.");
            } else {
                echo "Zespół został usunięty z bazy danych.";
            }
        }

        ?>

    </div>


    <div class="contentMain">

        <h1>Edytuj zespół</h1>


        <form method="post">

            <label for="editID">Wybierz zespół:</label>
            <select name="editiD" id="editID" required>
                <option value=""> Wybierz... </option>
                <?php
                $tmpqst = "SELECT id_zespolu, nazwa_zespolu FROM zespoly";
                $tmpquery = mysqli_query($connection, $tmpqst);
                while ($row = mysqli_fetch_array($tmpquery)) {
                    echo "<option value='" . $row['id_zespolu'] . "'>" . $row['id_zespolu'] . '  | ' . $row['nazwa_zespolu'] . "</option>";
                }
                ?>
            </select>



            <label for="editName">Nazwa zespołu: </label>
            <input type="text" name="editName" minlength="5" maxlength="16" required>



            <label for="editSelector">Wybierz przypisany projekt:</label>
            <select name="editSelector" id="editSelector" required>
                <option value=""> Wybierz... </option>
                <option value="NULL"> Brak projektu </option>
                <?php
                $projectquery = mysqli_query($connection, $addqst);
                while ($row = mysqli_fetch_array($projectquery)) {
                    echo "<option value='" . $row['id_projektu'] . "'>" . $row['id_projektu'] . " | " . $row['nazwa_projektu'] . "</option>";
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
            $editqst = "SELECT * FROM zespoly WHERE id_zespolu=$id";
            $editquery = mysqli_query($connection, $editqst);

            if (mysqli_num_rows($editquery) == 1) {

                $name = mysqli_real_escape_string($connection, $_POST['editName']);
                $idproj = mysqli_real_escape_string($connection, $_POST['editSelector']);

                $editqst2 = "UPDATE zespoly
                        SET nazwa_zespolu='$name', id_projektu=$idproj
                        WHERE id_zespolu=$id";


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