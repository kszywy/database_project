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
    <title>realizacja projektów</title>

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

    $qst = "SELECT * FROM projekty";
    $query = mysqli_query($connection, $qst);

    if (!$query) {
        die("Wystąpił błąd w trakcie łączenia się z bazą danych");
    }
    ?>

    <div class="contentMain">
        <?php

        echo "Łączna liczba projektów: <b>" . mysqli_num_rows($query) . "</b><br><br>";

        echo "<table class='fetchTable'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>" . "Nazwa projektu" . "</th>";
        echo "<th>" . "Status" . "</th>";
        echo "</tr>";
        echo "</thead><tbody>";
        while ($row = mysqli_fetch_array($query)) {
            $tmp = status($row['data_rozpoczecia'], $row['data_zakonczenia']);

            echo "<tr>";
            echo "<td>" . $row['nazwa_projektu'] . "</td><td>" .
                $tmp . "</td>";
            echo "<tr>";
        }
        echo "</tbody></table>";

        mysqli_close($connection);

        ?>

    </div>

</body>

</html>