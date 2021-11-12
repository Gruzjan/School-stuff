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

//zwroc ksiazke
if(isset($_POST['btnListReturn'])){
    $bookNum = $_POST['btnListReturn'];
    $query = "SELECT * FROM egzemplarzksiazki WHERE NrInwentarzowy LIKE '{$bookNum}'";
    $statement = mysqli_query($connection, $query);
    
    $row = mysqli_fetch_array($statement);
    if($row['CzyDost'] == 1){
        echo "Egzemplarz jest już zwrócony";
    }else{                
        $query = "UPDATE wypozyczenia SET DataZwrotu = CURRENT_DATE() WHERE NrInwentarzowy LIKE '$bookNum' AND DataZwrotu LIKE '0000-00-00'";
        $statement = mysqli_query($connection, $query);
        if($statement){
            $query = "UPDATE egzemplarzKsiazki SET CzyDOST = '1' WHERE NrInwentarzowy LIKE '$bookNum'";
            $statement = mysqli_query($connection, $query);
            if($statement){
                echo '<div class="alert alert-fixed alert-success" role="alert">Zwrocono pomyslnie</div>';
            }else{
                echo '<div class="alert alert-fixed alert-danger" role="alert">Cos poszlo nie tak</div>';
            }   
        }else{
            echo '<div class="alert alert-fixed alert-danger" role="alert">Cos poszlo nie tak</div>';
        }    
    }
}

//wypozycz ksiazke
if(isset($_POST['btnListBorrow'])){
    list($bookNum, $userId) = explode("-", $_POST['btnListBorrow'], 2);

    $query = "SELECT * FROM egzemplarzksiazki WHERE NrInwentarzowy LIKE '$bookNum'";
    $statement = mysqli_query($connection, $query);
    
    $row = mysqli_fetch_array($statement);
    if($row['CzyDost'] == 0){
        echo '<div class="alert alert-fixed alert-danger" role="alert">Ten egzemplarz nie jest dostepny. Wypożycz inny egzemplarz korzystając z menu wypożyczania</div>';
    }else{     
        $query = "INSERT INTO wypozyczenia(NrInwentarzowy, IdCzytelnika, DataWyp) VALUES ('$bookNum', '$userId', CURRENT_DATE())";
        $statement = mysqli_query($connection, $query);
        if($statement){
            $query = "UPDATE egzemplarzKsiazki SET CzyDOST = '0' WHERE NrInwentarzowy LIKE '{$bookNum}'";
            $statement = mysqli_query($connection, $query);
            if($statement){
                echo '<div class="alert alert-fixed alert-success" role="alert">Wypozyczono pomyslnie</div>';
            }else{
                echo '<div class="alert alert-fixed alert-danger" role="alert">Cos poszlo nie tak</div>';
            }
        }else{
            echo '<div class="alert alert-fixed alert-danger" role="alert">Cos poszlo nie tak</div>';
        }    
    }
}

//wypisz wypozyczenia
if(isset($_POST['btnAccount']) || isset($_POST['btnListBorrow']) || isset($_POST['btnListReturn'])){
    if(isset($_POST['btnAccount'])){
        $userId = $_POST['btnAccount'];
        $_SESSION['id'] = $userId;
    }
    $userId = $_SESSION['id'];

    $query = "SELECT * FROM czytelnicy WHERE Id LIKE '$userId'";
    $statement = mysqli_query($connection, $query);
    
    
    $row = mysqli_fetch_array($statement);
    echo "<div class='text-orange' style='margin-right: 150px;'>";
    echo "{$row['Imie']} {$row['Nazwisko']} {$row['Klasa']}<br></div>";
    echo "<table class='text-center'><tr class='text-orange'><th>Tytuł</th><th>Autor</th><th>Nr inwentarzowy</th><th>Data wypożyczenia</th><th>Data oddania</th><th>Akcje</th></tr>";
    
    //nieoddane
    $query = "SELECT * FROM wypozyczenia JOIN egzemplarzksiazki ON egzemplarzksiazki.NrInwentarzowy = wypozyczenia.NrInwentarzowy JOIN ksiazki ON ksiazki.Id = egzemplarzksiazki.IdKsiazki WHERE wypozyczenia.IdCzytelnika LIKE '$userId' AND DataZwrotu LIKE '0000-00-00' ORDER BY wypozyczenia.DataWyp DESC";
    $statement = mysqli_query($connection, $query);
    
    while ($row1 = mysqli_fetch_array($statement)){
        echo "<tr class='text-yellow'><td>{$row1['Tytul']}</td><td>{$row1['Autor']}</td><td>{$row1['NrInwentarzowy']}</td><td>{$row1['DataWyp']}</td><td>{$row1['DataZwrotu']}</td><td><form action='' method='post'><button class='btn btn-sm btn-outline-warning' value='{$row1['NrInwentarzowy']}' name='btnListReturn'>Zwróć</button></form></td><tr>";
    }
    
    //oddane
    $query = "SELECT * FROM wypozyczenia JOIN egzemplarzksiazki ON egzemplarzksiazki.NrInwentarzowy = wypozyczenia.NrInwentarzowy JOIN ksiazki ON ksiazki.Id = egzemplarzksiazki.IdKsiazki WHERE wypozyczenia.IdCzytelnika LIKE '$userId' AND wypozyczenia.DataZwrotu NOT LIKE '0000-00-00' ORDER BY wypozyczenia.DataZwrotu DESC";
    $statement = mysqli_query($connection, $query);
    while ($row2 = (mysqli_fetch_array($statement))){
        echo "<tr class='text-yellow'><td>{$row2['Tytul']}</td><td>{$row2['Autor']}</td><td>{$row2['NrInwentarzowy']}</td><td>{$row2['DataWyp']}</td><td>{$row2['DataZwrotu']}</td><td><form action='' method='post'><button class='btn btn-sm btn-outline-warning' value='{$row2['NrInwentarzowy']}-$userId' name='btnListBorrow'>Wypożycz</button></form></td><tr>";
    }
    echo "</table>";
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
    
</body>
</html>