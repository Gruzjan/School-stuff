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


//wyszukaj ksiazki z gatunkow
if(isset($_POST['btnGenre'])){
    $genre = $_POST['genre'];

    $query = "SELECT * FROM ksiazki WHERE Gatunek IN (";
    
    foreach($genre as $val)
    {
        $query .= "'" . $val . "',";
    }
    $query .= " '');";
    
    $statement = mysqli_query($connection, $query);
    //wypisz wyniki
    
    echo "<div style='margin-right: 50px;'><table class='text-center'><tr class='text-orange'><th>Autor</th><th>Tytul</th><th>Gatunek</th><th>Wydawnictwo</th></tr>";
    
    while (($row = mysqli_fetch_array($statement))) {
        echo "<tr class='text-yellow'><td>{$row['Autor']}</td><td>{$row['Tytul']}</td><td>{$row['Gatunek']}</td><td>{$row['Wydawnictwo']}</td><tr>";
    }
    
    echo '</table></div>';
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
    <form action="" method="post" class="form-genre align-middle border border-warning rounded">
    <h1 class="h3 mb-3 text-yellow font-weight-normal">Wyświelt książki z gatunku</h1>
    <p>Możesz wybrać wiele gatunków na raz.</p>
        <?php
            include "connect.php";
            $connection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
            $query = "SELECT DISTINCT Gatunek FROM ksiazki";
            $statement = mysqli_query($connection, $query);
            while ($list=mysqli_fetch_array($statement)){
                ?>
                    <input class="form-check-input" type="checkbox" name="genre[]" value="<?php echo $list['Gatunek'];?>"><?php echo $list['Gatunek'];?><br>
                <?php
                    }
                    mysqli_close($connection);
        ?>
        <button type="submit" name="btnGenre" class="col-xs-12 btn btn-primary btn-load btn-lg" >Wyświetl</button>
    </form>
</div>
    
</body>
</html>