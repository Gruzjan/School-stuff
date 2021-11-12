<?php 
session_start();

//jesli nie ma loginu w sesji odeslij do logowania
if (!isset($_SESSION['login']) || empty($_SESSION['login'])) {
      header("Location: index.php");
      exit();
}

//jesli klikniety logout wyczysc zmienne sesji, ciasteczka, przenies do logowania
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

//jesli znalazlo czytelnika o danym loginie i hasle ustaw typ konta na uzytkownik i odeslij do odpowiedniej strony, jesli nie to szukaj w bibliotekarzach
//jesli to bibliotekarz to ustaw odpowiednie dane
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

    <!-- Custom styles for this template -->
    <link href="css/menu.css" rel="stylesheet">
    
  </head>

  <body class='text-center'>

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

          <!-- wyloguj -->
          <form action="" method="post" class="my-2 my-md-0">
            <button name="logout" class="btn btn-primary">Wyloguj</button>
          </form>

      </div>
    </nav>

    <main role="main">
      <!-- album kafelkow ze zdjeciem, tytulem, opisem i przycisikiem -->
      <div class="py-5">

        <!-- hr -->
        <div class="header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
          <h1 class="display-4"><b id="hr">Zarządzaj kontami</b></h1>
        </div>

      
        <div class="container">

          <div class="row">

            <div class="col-md-4">
              <div class="card mb-4 box-shadow bg-warning">
                <div class="card-header">
                  <h4 class="my-0 text-center font-weight-normal">Zmień hasło</h4>
                </div>
                <img class="card-img-top" src="img/haslo.png" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">Tutaj ekspresowo zmienisz hasło dla swojego konta.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="col text-center ">
                      <a href="stronaZmienHaslo.php"><button type="button" class="btn btn-primary">Przejdź</button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card mb-4 box-shadow bg-warning">
                <div class="card-header">
                  <h4 class="my-0 text-center font-weight-normal">Zarządzaj uczniami klasy</h4>
                </div>
                <img class="card-img-top" src="img/uczniowie.png" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">Wybierając klasę zarządzasz uczniami oraz ich wypożyczeniami.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="col text-center ">
                      <a href="stronaOsoby.php"><button type="button" class="btn btn-primary">Przejdź</button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card mb-4 box-shadow bg-warning">
                <div class="card-header">
                  <h4 class="my-0 text-center font-weight-normal">Sprawdź stan konta</h4>
                </div>
                <img class="card-img-top" src="img/stan.png" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">Tutaj sprawdzisz czy konto czytelnika jest aktywne.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="col text-center ">
                      <a href='stronaAktywne.php'><button type="button" class="btn btn-primary">Przejdź</button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div><!-- row  -->

          <!-- hr -->
          <div class="header px-4 py-4 pt-md-4 pb-md-4 mx-auto text-center">
            <h1 class="display-4"><b id="hr">Zarządzaj książkami</b></h1><br>
          </div>

          <div class="row">

            <div class="col-md-4">
              <div class="card mb-4 box-shadow bg-warning">
                <div class="card-header">
                  <h4 class="my-0 text-center font-weight-normal">Książki z gatunków</h4>
                </div>
                <img class="card-img-top" src="img/gatunek.png" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">Wyszukasz tutaj wszystkie książki wybranego gatunku z naszej biblioteki.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="col text-center ">
                      <a href="stronaGatunek.php"><button type="button" class="btn btn-primary">Przejdź</button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card mb-4 box-shadow bg-warning">
                <div class="card-header">
                  <h4 class="my-0 text-center font-weight-normal">Dostępne książki</h4>
                </div>
                <img class="card-img-top" src="img/dostepne.png" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">Wyszukasz wszystkie dostępne lub niedostępne książki z naszej biblioteki.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="col text-center ">
                      <a href='stronaDostepne.php'><button type="button" class="btn btn-primary">Przejdź</button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card mb-4 box-shadow bg-warning">
                <div class="card-header">
                  <h4 class="my-0 text-center font-weight-normal">Książki autora</h4>
                </div>
                <img class="card-img-top" src="img/autor.png" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">Podając imie i nazwisko autora wyświetlisz wszystkie jego książki dostępne u nas</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="col text-center ">
                    <a href='stronaKsiazkiAutora.php'><button type="button" class="btn btn-primary">Przejdź</button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div><!-- row  -->

          <div class="row">

            <div class="col-md-4">
              <div class="card mb-4 box-shadow bg-warning">
                <div class="card-header">
                  <h4 class="my-0 text-center font-weight-normal">Szukaj po tytule</h4>
                </div>
                <img class="card-img-top" src="img/tytul.png" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">Sprawdź, czy mamy książkę, której szukasz.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="col text-center ">
                        <a href='stronaSzukajTytul.php'><button type="button" class="btn btn-primary">Przejdź</button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card mb-4 box-shadow bg-warning">
                <div class="card-header">
                  <h4 class="my-0 text-center font-weight-normal">Dodaj nową</h4>
                </div>
                <img class="card-img-top" src="img/nowa.png" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">Dodaj nową książkę.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="col text-center ">
                    <a href='stronaDodajKsiazke.php'><button type="button" class="btn btn-primary">Przejdź</button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-md-4">
              <div class="card mb-4 box-shadow bg-warning">
                <div class="card-header">
                  <h4 class="my-0 text-center font-weight-normal">Dodaj egzemplarz</h4>
                </div>
                <img class="card-img-top" src="img/nowy.png" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">Dodaj nowy egzemplarz dla książki.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="col text-center ">
                    <a href='stronaDodajEgzemplarz.php'><button type="button" class="btn btn-primary">Przejdź</button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div><!-- row  -->

          <div class="row">

            <div class="col-md-4">
              <div class="card mb-4 box-shadow bg-warning">
                <div class="card-header">
                  <h4 class="my-0 text-center font-weight-normal">Wypożycz</h4>
                </div>
                <img class="card-img-top" src="img/wypozycz.png" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">Wypożyczysz książkę czytelnikowi</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="col text-center ">
                    <a href='stronaWypozyczenie.php'><button type="button" class="btn btn-primary">Przejdź</button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card mb-4 box-shadow bg-warning">
                <div class="card-header">
                  <h4 class="my-0 text-center font-weight-normal">Zwróć</h4>
                </div>
                <img class="card-img-top" src="img/zwrot.png" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">Zaznaczysz książkę jako zwróconą</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="col text-center ">
                    <a href='stronaZwrot.php'><button type="button" class="btn btn-primary">Przejdź</button></a>
                    </div>
                  </div>
                </div>
              </div>
          </div><!-- row  -->

        </div>
        
      </div>
    </div>

    <!-- stopka -->
    <footer class="text-muted">
      <div class="container">
        <p>  Biblioteka JBB Bałdyga 2020 &copy;</p>
        <p> Strona wykonana przez: Gracjan Wiśniewski</p>
      </div>
    </footer>

    <!-- Bootstrapowe rzeczy  -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-slim.min.js"><\/script>')</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js%22%3E"></script>
    <script src="js/holder.min.js"></script> 

  </body>
</html>
