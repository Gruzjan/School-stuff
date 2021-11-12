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

if($row = (mysqli_fetch_array($statement))){
    $site = "czytelnik";
    header("Location: $site.php");
}else{
    $query = "SELECT * FROM bibliotekarze WHERE Login = '$login' AND Haslo = '$pass'";
    $statement = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($statement);
    $type = "bibliotekarz";
    $name = $row['Imie'];
    $surname = $row['Nazwisko'];
}

//dodaj ksiazke
if(isset($_POST['btnAddBook'])){
    //zapisz podane informacje
    $addAuthor = $_POST['addAuthor'];
    $addTitle = $_POST['addTitle'];
    $addGenre = $_POST['addGenre'];
    $addPublisher = $_POST['addPublisher'];

    //wprowadz do bazy, poinformuj o wynikachs
    $query = "INSERT INTO ksiazki(Autor, Tytul, Gatunek, Wydawnictwo) VALUES ('{$addAuthor}', '{$addTitle}', '{$addGenre}', '{$addPublisher}')";
    $statement = mysqli_query($connection, $query);

    if($statement){
        echo '<div class="alert alert-fixed alert-success" role="alert">Dodano książkę</div>';
    }else{
        echo '<div class="alert alert-fixed alert-danger" role="alert">Coś poszło nie tak</div>';
    }   
}

mysqli_close($connection);

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
<body>
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
        <form action="" method="post" class="form-add align-middle border border-warning rounded">
            <h1 class="h3 mb-3 text-yellow font-weight-normal">Dodaj nową książkę</h1>
            <p>Każde pole jest wymagane.</p>
            <input type="text" class="input-lg form-control" name="addAuthor"  placeholder="Autor" required><br>
            <input type="text" class="input-lg form-control" name="addTitle" placeholder="Tytuł" required><br>
            <input type="text" class="input-lg form-control" name="addGenre"  placeholder="Gatunek" required><br>
            <input type="text" class="input-lg form-control" name="addPublisher"  placeholder="Wydawnictwo" required><br>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name='btnAddBook'>Dodaj</button>
        </form>
    </div>

    
</body>
</html>