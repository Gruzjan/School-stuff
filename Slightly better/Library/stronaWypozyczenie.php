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

//wypozyczanie
if(isset($_POST['btnBorrow'])){
    $userId = $_POST['borrUser'];
    $borrNum = $_POST['borrNum'];
    
    $query = "SELECT * FROM egzemplarzksiazki WHERE NrInwentarzowy LIKE '$borrNum'";
    echo $query;
    $statement = mysqli_query($connection, $query);
    
    //sprawdz czy ksiazka jest dostepna do wypozyczenia, z pomoca stworzonego zapytania zmian dostepnosc na 0 i poinformuj o wyniku wypozyczania
    $row = mysqli_fetch_array($statement);
    if($row['CzyDost'] == 0){
        echo '<div class="alert alert-fixed alert-danger" role="alert">Egzemplarz nie jest dostępny</div>';
    }else{     
        $query = "INSERT INTO wypozyczenia(NrInwentarzowy, IdCzytelnika, DataWyp) VALUES ('$borrNum', '$userId', CURRENT_DATE())";
        $statement = mysqli_query($connection, $query);
        if($statement){
            $query = "UPDATE egzemplarzKsiazki SET CzyDOST = '0' WHERE NrInwentarzowy LIKE '{$borrNum}'";
            $statement = mysqli_query($connection, $query);
            if($statement){
                echo '<div class="alert alert-fixed alert-success" role="alert">Wypożyczono pomyślnie</div>';
            }else{
                echo '<div class="alert alert-fixed alert-danger" role="alert">Coś poszło nie tak</div>';
            }
        }else{
            echo '<div class="alert alert-fixed alert-danger" role="alert">Coś poszło nie tak</div>';
        }    
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
        <form action="" method="post" class="form-add align-middle border border-warning rounded">
            <h1 class="h3 mb-3 text-yellow font-weight-normal">Wypożycz książkę</h1>
            <p>Oba pola są wymagane.</p>

            <select class="form-control" name="borrUser">
            <?php
                include "connect.php";
                $connection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
                $statement = mysqli_query($connection, "SELECT * FROM czytelnicy");
                while ($list=mysqli_fetch_array($statement)){
                ?>
                    <option value="<?php echo $list['Id'];?>"> <?php echo ($list['Login']);?></option>
                <?php
                }
            mysqli_close($connection);
            ?>
        </select><br>
            <input type="text" class="input-lg form-control" name="borrNum"  placeholder="Nr inwentarzowy" required><br>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name='btnBorrow'>Wypożycz</button>
        </form>
    </div>

</body>
</html>