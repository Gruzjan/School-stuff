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

//szukaj ksiazki o tytule
if(isset($_POST['btnTitle'])){
    $title = $_POST['title'];

    //stworz i wykonaj zapytanie aby zdobyc id dostepnych/niedostepnych ksiazek
    $query = "SELECT * FROM ksiazki JOIN egzemplarzksiazki ON ksiazki.Id = egzemplarzksiazki.IdKsiazki WHERE Tytul LIKE '%$title%'";
    $statement = mysqli_query($connection, $query);
    
    //wypisz w tablicy
    echo "<div style='margin-right: 150px;'><table class='text-center'><tr class='text-orange'><th>Autor</th><th>Tytul</th><th>Nr Inwentarzowy</th><th>Dostepnosc</th></tr>";
    while ($row = (mysqli_fetch_array($statement))){
        echo "<tr class='text-yellow'><td>{$row['Autor']}</td><td>{$row['Tytul']}</td><td>{$row['NrInwentarzowy']}</td><td>{$row['CzyDost']}</td><tr>";
    }
    echo "</table></div>";
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
    <link href="css/osoby.css" rel="stylesheet">
    
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
    <div>
        <form action="" method="post" class="form-search align-middle border border-warning rounded">
            <h1 class="h3 mb-3 text-yellow font-weight-normal">Znajdź książki po tytule.</h1>
            <p>Wystarczy znać tylko kawałek :).</p>
            <input type="text" class="input-lg form-control" name="title"  placeholder="Tytuł"  required><br>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name='btnTitle'>Wyszukaj</button>
        </form>
    </div>

    
</body>
</html>