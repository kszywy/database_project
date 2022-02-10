<?php

require("../php/database.php");

?>

<!DOCTYPE html>
<html lang="pl">

<!-- <a href="https://www.flaticon.com/free-icons/portable-document-format" title="portable document format icons">Portable document format icons created by Ilham Fitrotul Hayat - Flaticon</a> -->
<!-- <a href="https://www.flaticon.com/free-icons/user" title="user icons">User icons created by Freepik - Flaticon</a> -->

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="Wojciech Cioczek" />
  <meta name="description" content="Zadanie projektowe" />
  <title>Logowanie</title>

  <link rel="shortcut icon" href="../images/xyz.ico" />
  <link rel="stylesheet" href="../styles/style.css" type="text/css" />
  <link rel="stylesheet" href="../styles/loginStyle.css" type="text/css" />
</head>

<body>

  <?php
  if (!$connection) {
    die('Wystąpił błąd przy łączeniu z bazą danych.');
    echo "</body></html>";
  }
  ?>

  <div id="box">
    <h1>LOGOWANIE</h1>
    <form method="post">

      <label><input type="text" name="login" placeholder="Nazwa użytkownika" required></label>
      <label><input type="password" name="password" placeholder="Hasło" required></label>
      <input type="submit" name="enter" value="Zaloguj się">

    </form>

    <?php

    if (isset($_POST['enter'])) {
      $login = mysqli_real_escape_string($connection, $_POST['login']);
      $pass = mysqli_real_escape_string($connection, $_POST['password']);

      $query = "SELECT haslo FROM konta WHERE login='$login'";
      $result = mysqli_query($connection, $query);

      if (mysqli_num_rows($result) == 0) {
        echo "Login nie istnieje. Spróbuj ponownie.";
      } else if (mysqli_num_rows($result) == 1) {
        $arr = mysqli_fetch_array($result);

        if (password_verify($pass, $arr['haslo'])) {
          session_start();
          $_SESSION['zalogowany'] = 1;
          $_SESSION['użytkownik'] = $login;
          header("Location: ../main/panel.php");
        } else {
          echo "Błędne hasło. Spróbuj ponownie.";
        }
      }
    }

    mysqli_close($connection);

    ?>

  </div>

  <div id="box2">
    <a href="../main/price.html">
      Cennik projektu
      <span class="linkSpanner"></span>
    </a>
  </div>

  <div id="footer">
    <p>
      Copyright © 2022 Wojciech Cioczek / XYZ.data
      <br><br>
      <a href="https://www.flaticon.com/free-icons/user" title="user icons" target="_blank">User icons created by Freepik - Flaticon</a>
    </p>

</body>

</html>