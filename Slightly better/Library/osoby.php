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

//usun uzytkownika sprawdzajac czy nie ma wypozyczonych ksiazek
if(isset($_POST['btnAccountDelete'])){
    $id = $_POST['btnAccountDelete'];

    $query = "SELECT * FROM wypozyczenia WHERE wypozyczenia.IdCzytelnika LIKE '$id' AND DataZwrotu LIKE '0000-00-00'";
    $statement = mysqli_query($connection, $query);

    if(mysqli_fetch_array($statement)){
        echo '<div class="alert alert-fixed alert-danger" role="alert">Nie można usunąć czytelnika z powodu wypożyczonych książek</div>';
    }else{
        $query = "DELETE FROM czytelnicy WHERE Id LIKE '$id'";
        $statement = mysqli_query($connection, $query);
        if($statement){
            echo '<div class="alert alert-fixed alert-success" role="alert">Pomyślnie usunięto czytelnika</div>';
        }else{
            echo '<div class="alert alert-fixed alert-danger" role="alert">Cos poszlo nie tak</div>';
        }
    }
}

//dodaj uzytkownika pilnujac zeby imie i nazwisko nie mialo specjalnych znakow, dane zaszyfruj i przeslij do bazy, poinformuj o wynikach
if(isset($_POST['btnAddUser'])){
    $addName = ucfirst(strtolower($_POST['addName']));
    $addSurname = ucfirst(strtolower($_POST['addSurname']));
    $class = $_POST['btnAddUser'];

    if(isset($_POST['addIsActive'])){
        $isActive = 1;
    }else{
        $isActive = 0;
    }

    $forbidden = "/['1234567890!^£$%&*()}{@#~?><>,|=+¬-]/";

    if(preg_match($forbidden, $addName) || preg_match($forbidden, $addSurname)){
        echo '<div class="alert alert-fixed alert-danger" role="alert">Imię i nazwisko nie może zawierać znaków specjalnych</div>';
    }

    $login = $addName[0].$addSurname[0].rand(10, 99);
    $pass = md5(rand(0,9).$addName.$class.$addSurname."!");

    $query = "SELECT Login FROM czytelnicy WHERE Login LIKE '$login'";
    $statement = mysqli_query($connection, $query);

    while(mysqli_fetch_array($statement)){
        $login = $addName[0].$addSurname[0].rand(10, 99);
        $statement = mysqli_query($connection, $query);
    }

    $query = "INSERT INTO czytelnicy(Login, Imie, Nazwisko, Haslo, Klasa, CzyAkt) VALUES ('$login', '$addName', '$addSurname', '$pass', '$class', '$isActive')";
    $statement = mysqli_query($connection, $query);

    if($statement){
        echo '<div class="alert alert-fixed alert-success" role="alert">Dodano nowego czytelnika</div>';
    }else{
        echo '<div class="alert alert-fixed alert-danger" role="alert">Cos poszlo nie tak</div>';
    }
}

//wyswietl klase
if(isset($_POST['btnClass']) || isset($_POST['btnAddUser']) || isset($_POST['btnAccountDelete'])){
    if(isset($_POST['btnClass'])){
        $class = $_POST['class'];
        $_SESSION['class'] = $class;
    }
    $class = $_SESSION['class'];

    $query = "SELECT * FROM czytelnicy WHERE klasa LIKE '$class';";
    $statement = mysqli_query($connection, $query);

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


<!-- formularz -->
    <div>
    <form action="" method="post" class="form-add border border-warning text-center rounded">
        <h1 class="h3 mb-3 text-yellow font-weight-normal">Dodaj nowego czytelnika</h1>

        <input type="login" name="addName" class="form-control" placeholder="Imię" required>
        <input type="text" name="addSurname" class="form-control" placeholder="Nazwisko" required>
        <input class="form-check-input" name="addIsActive" type="checkbox" id="checkbox">
        <label class="form-check-label" for="checkbox">
        Czy aktywne
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="btnAddUser" value="<?php echo $class; ?>">Dodaj</button>   
    
    </form>
    </div>

    <!-- jesli zapytanie wykonalo sie poprawnie wyswietl wyniki -->
    <div style="margin-left: 250px;">
    <?php if($statement){ ?>
        <table class='text-center'><tr class="text-orange"><th>Imię</th><th>Nazwisko</th><th>Klasa</th><th>Wypożyczenia</th><th>Modyfikuj</th><th>Usuń</th></tr>
        <?php while ($row = mysqli_fetch_array($statement)){
        echo "<tr><td class='text-yellow'>{$row['Imie']}</td><td class='text-yellow'>{$row['Nazwisko']}</td><td class='text-yellow'>{$row['Klasa']}</td><td><form action='konto.php' method='post'><button class='btn btn-sm btn-outline-warning' type='submit' name='btnAccount' value='{$row['Id']}'>Wyświetl</button></form></td><td><form action='modyfikuj.php' method='post'><button class='btn btn-sm btn-outline-warning' type='submit' name='btnAccountModify' value='{$row['Id']}'>Modyfikuj</button></form></td><td><form action='' method='post'><button class='btn btn-sm btn-outline-warning' type='submit' name='btnAccountDelete' value='{$row['Id']}'>Usuń</button></form></td><tr>";
        }?>
    </table><br>
    <?php }?>
    </div>


</body>
</html>
