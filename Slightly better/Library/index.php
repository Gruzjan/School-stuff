<?php
session_start();
require "connect.php"; 

error_reporting(E_ALL ^ E_NOTICE);

$connection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

if ($connection === false) {
    echo 'Błąd łączenia z bazą danych ' . mysqli_connect_errno() . ', opis błędu ' . mysqli_connect_error();
    exit;
}

$login = $_POST['login'];
$pass = substr(md5($_POST['pass']), 0, -2);

//jesli juz zalogowany odeslij do odpowiedniej strony
if(isset($_SESSION['login'])){
    $site = $_SESSION['site'];
    header("Location: $site.php");
}else if($login != "" && $pass != ""){  //jesli wypelniony formularz logowania ustaw odpowiednie zapytania dla uzytkownika w celu zalogowania
    if(isset($_POST['isUser'])){
        $query= "SELECT * FROM czytelnicy WHERE Login = '$login' AND Haslo LIKE '$pass'";
        $site = "czytelnik";
    }else{
        $query= "SELECT * FROM bibliotekarze WHERE Login = '$login' AND Haslo LIKE '$pass'";
        $site = "bibliotekarz";
    }
    $statement = mysqli_query($connection, $query);//jesli zalogowany poprawnie przypisz potrzebne dane do zmiennych sesji, jesli blad to alert
    if(mysqli_fetch_array($statement)){
        $_SESSION['login'] = $login;
        $_SESSION['pass'] = $pass;
        $_SESSION['site'] = $site;
    }else{
        echo '<div class="alert alert-fixed alert-danger" role="alert">Nieprawidłowy login, hasło, lub typ konta</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="logo.png">

    <title>Zaloguj się</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/login.css" rel="stylesheet">
</head>
<body class="text-center"> 

    <?php //jesli juz zalogowany odeslij do strony
    if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
        $site = $_SESSION['site'];
        header("Location: $site.php");
    } else { ?>
    <div>
    <!-- formularz -->
    <h1 id="name" class="h3 mb-3 font-weight-normal">Biblioteka JBB Bałdyga</h1>
    <form action="" method="post" class="form-signin border border-warning rounded">
      <img class="mb-4" src="img/logo.png" alt="logo" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Zaloguj się</h1>

      <label for="inputLogin" class="sr-only">Login</label>
      <input type="login" id="inputLogin" name="login"class="form-control" placeholder="Login" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Hasło" required>

      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" name="isUser"> Czytelnik
        </label>
      </div>

      <button class="btn btn-lg btn-primary btn-block" type="submit" name='btnLogIn'>Zaloguj</button>
      <p class="mt-5 mb-3 text-muted">Wykonane przez: Gracjan Wiśniewski</p>
    </form>
  </div>
    <?php } ?>

</body>
</html>