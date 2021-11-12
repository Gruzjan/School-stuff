<?php 
session_start();

if (!isset($_SESSION['login']) || empty($_SESSION['login'])) {
      header("Location: index.php");
      exit();
}

if(isset($_POST['logout'])){
    session_unset();
	if ($_COOKIE[session_name()])
	{
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	header('Location: index.php');
}

require "connect.php"; 

error_reporting(E_ALL ^ E_NOTICE);

$connection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

if ($connection === false) {
    echo 'Błąd łączenia z bazą danych ' . mysqli_connect_errno() . ', opis błędu ' . mysqli_connect_error();
    exit;
}

$login = $_SESSION["login"];
$pass = $_SESSION["pass"];
$query = "SELECT * FROM czytelnicy WHERE Login = '$login' AND Haslo = '$pass'";
$statement = mysqli_query($connection, $query);

if($row = mysqli_fetch_array($statement)){
    $type = "czytelnik";
    $name = $row['Imie'];
    $surname = $row['Nazwisko'];
}else{
    $query = "SELECT * FROM bibliotekarze WHERE Login = '$login' AND Haslo = '$pass'";
    $statement = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($statement);
    $type = "bibliotekarz";
    $name = $row['Imie'];
    $surname = $row['Nazwisko'];
}

//zmiana hasla
if(isset($_POST['change'])){
    //zbierz i zaszyfruj dane
    $pass = substr(md5($_POST['pass']), 0, -2);
    $passNew = md5($_POST['passNew']);
    $passNewA = md5($_POST['passNewA']);
    $login = $_SESSION['login'];
    $type;
    
    $query = "SELECT * FROM czytelnicy WHERE Login = '$login' AND Haslo = '$pass'";
    $statement = mysqli_query($connection, $query);
    
    //sprawdz czy zmiana haslo czytelnik czy bibliotekarz
    if($row = mysqli_fetch_array($statement)){
        $type = "czytelnicy";
    }else{
        $query = "SELECT * FROM bibliotekarze WHERE Login = '$login' AND Haslo = '$pass'";
        $statement = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($statement);
        $type = "bibliotekarze";
    }
    
    //sprawdz wszystkie wymagania co do hasla, jesli wszystko ok zmien je i poinformuj
    if($pass == "" || $passNew == "" || $passNewA == ""){
        echo '<div class="alert alert-fixed alert-danger" role="alert">Wszystkie pola muszą być wypełnione</div>';
    }else if($row['Haslo'] != $pass){
        echo '<div class="alert alert-fixed alert-danger" role="alert">Nieprawidłowe hasło</div>';
    }else if(substr($passNew, 0, -2) == $row['Haslo']){
        echo '<div class="alert alert-fixed alert-danger" role="alert">Aktualne hasło nie może być nowym hasłem</div>';
    }else if($passNew != $passNewA){
        echo '<div class="alert alert-fixed alert-danger" role="alert">Hasła muszą do siebie pasować</div>';
    }else if(strlen($_POST['passNew']) < 5){
        echo '<div class="alert alert-fixed alert-danger" role="alert">Nowe hasło jest za krótkie</div>';
    }else if(!preg_match('/[A-ZĄĆĘŁŃÓŚŹŻ]/', $_POST['passNew'])){
        echo '<div class="alert alert-fixed alert-danger" role="alert">Nowe hasło musi mieć przynajmniej jedną dużą literę</div>';
    }else if(!preg_match('/[0-9]/', $_POST['passNew'])){
        echo '<div class="alert alert-fixed alert-danger" role="alert">Nowe hasło musi mieć przynajmniej jedną cyfrę</div>';
    }else if($passNew == $passNewA && $row['Haslo'] == $pass){
        $query = "UPDATE $type SET Haslo = '$passNew' WHERE Login = '$login'";
        $statement = mysqli_query($connection, $query);
        if($statement){
            echo '<div class="alert alert-fixed alert-success" role="alert">Hasło zostało zmienione pomyślnie</div>';
            $_SESSION['pass'] = substr($passNew, 0, -2);
        }else{
            echo '<div class="alert alert-fixed alert-danger" role="alert">Nieprawidłowy login, hasło, lub typ konta</div>';
        }   
    }
}


?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="img/logo.png">

    <title>Biblioteka</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/zmienHaslo.css" rel="stylesheet">
    
  </head>
<body class="text-center">
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark"> 
      <div class="container">

          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <!-- Kto zalogowany -->
              <span class="navbar-text text-yellow">
                Zalgowano jako: <?php  echo "<span class='text-orange'>$name $surname</span>" ?>; Typ konta: <?php echo "<span class='text-orange'>$type</span>"; ?>
              </span>
            </li>
          </ul>

          <!-- log out -->
          <form class="my-2 my-md-0" action="" method="post">
            <button name="logout" class="btn btn-primary">Wyloguj</button>
          </form>

      </div>
    </nav>
    
    <!-- formularz -->
    <form action="" method="post" class="form-change align-middle border border-warning rounded">
        <h1 class="h3 mb-3 text-yellow font-weight-normal">Zmień swoje hasło</h1>
        <p>Hasło musi mieć minimum 5 znaków, jedną wielką literę oraz jedną cyfrę.</p>
        <input type="password" class="input-lg form-control" name="pass"  placeholder="Aktualne hasło" autocomplete="off" required><br>
        <input type="password" class="input-lg form-control" name="passNew" placeholder="Nowe hasło" autocomplete="off" required><br>
        <input type="password" class="input-lg form-control" name="passNewA"  placeholder="Powtórz hasło" autocomplete="off" required><br>

        <button class="btn btn-lg btn-primary btn-block" type="submit" name='change'>Zmień</button>
    </form>
           
</body>
</html>