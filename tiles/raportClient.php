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
    <title>Raport klienta</title>

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

    $qst = "SELECT id_klienta, nazwa FROM klienci";
    $query = mysqli_query($connection, $qst);

    if (!$query) {
        die("Wystąpił błąd w takcie łączenia się z bazą danych");
    }

    ?>

    <div class="contentMain">

        <form method="post">
            <label for="projektSelect">Wybierz klienta:</label>
            <select name="selector" id="projektSelect" required>
                <option value=""> Wybierz... </option>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    echo "<option value='" . $row['id_klienta'] . "'>" . $row['id_klienta'] . " | " . $row['nazwa'] . "</option>";
                }
                ?>
            </select>

            <div class="submit">
                <input type="submit" name="selectSubmitter" value="Pokaż" class="tab">
            </div>

        </form>

    </div>

    <?php

    if (isset($_POST['selectSubmitter'])) {
        $value = $_POST['selector'];
        $qst2 = "SELECT * FROM klienci WHERE id_klienta='$value'";
        $query2 = mysqli_query($connection, $qst2);

        echo '<div class="contentMain">';
        echo "<table class='fetchTable'>";
        echo "<thead>";
        echo "<tr>";
        for ($i = 0; $i < 6; $i++) {
            echo "<th>" . mysqli_fetch_field_direct($query2, $i)->name . "</th>";
        }
        echo "</tr>";
        echo "</thead><tbody>";
        while ($row = mysqli_fetch_array($query2)) {

            echo "<tr>";
            echo "<td>" . $row['id_klienta'] . "</td><td>" .
                $row['nazwa'] . "</td><td>" .
                $row['miejscowosc'] . "</td><td>" .
                $row['ulica'] . "</td><td>" .
                $row['numer_domu'] . "</td><td>" .
                $row['email'] . "</td>";
            echo "<tr>";
        }
        echo "</tbody></table></div>";
    }

    mysqli_close($connection);
    ?>

</body>

</html>