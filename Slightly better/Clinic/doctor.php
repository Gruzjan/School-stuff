<?php 
session_start();

//if there is no login in session (user is not logged in) move to login site 
if (!isset($_SESSION['login']) || empty($_SESSION['login'])) {
      header("Location: index.php");
      exit();
}

//if logout button is pressed clear session variables, cookies and move to login site
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

//if doctor with this login and password is found set session variables, else move to registrant's site
$login = $_SESSION["login"];
$pass = $_SESSION["pass"];
$query = "SELECT * FROM lekarze WHERE login = '$login' AND haslo = '$pass'";
$statement = mysqli_query($connection, $query);

if($row = (mysqli_fetch_array($statement))){
    $name = $row['imie'];
    $surname = $row['nazwisko'];
}else{
    header("Location: registrant.php");
}
?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="img/logo.png">

    <title>JBB Bałdyga Medical Clinic</title>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- My css -->
    <link href="css/menu.css" rel="stylesheet">
    
  </head>

  <body class='text-center'>

    <!-- navbar -->
    <nav class="navbar fixed-top navbar-expand-lg bg-light">
        <div class="container">

            <!-- navbar items -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                <!-- Who's logged in -->
                <span class="navbar-text text-blue">
                    <b>Logged in as: <?php  echo "<span class='text-white'>$name $surname</span></b>" ?>
                </span>
                </li>
            </ul>

            <!-- logout -->
            <form action="" method="post" class="my-2 my-md-0">
                <button name="logout" class="btn btn-primary">Logout</button>
            </form>

        </div>
    </nav>

    <main role="main">
        <!-- album of cards with pictures, titles, descriptions and buttons -->
        <div class="py-5">

            <!-- hr -->
            <div class="header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                <h1 class="display-4"><b class="hr">Manage appointments</b></h1>
            </div>

            <div class="container">

                <!-- new row -->
                <div class="row"> 

                    <!-- 1st card of row -->
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <div class="card-header">
                                <h4 class="my-0 text-center font-weight-normal text-blue">Your today's appointments</h4>
                            </div>
                            <img class="card-img-top" src="img/appointmentsDoc.png" alt="Card image cap">
                            <div class="card-body">
                                <p class="card-text">Shows your today's appointments and patient's history.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col text-center ">
                                        <a href="appointmentsDoc.php"><button type="button" class="btn btn-primary">Show</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2nd card of row -->
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow ">
                            <div class="card-header">
                                <h4 class="my-0 text-center font-weight-normal text-blue">Patients' data</h4>
                            </div>
                            <img class="card-img-top" src="img/patients.png" alt="Card image cap">
                            <div class="card-body">
                                <p class="card-text">Shows data of your patients like name, surname, birth date, etc.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col text-center ">
                                        <a href="patientsDoc.php"><button type="button" class="btn btn-primary">Show</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- end of row  -->

                <!-- hr -->
                <div class="header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                    <h1 class="display-4"><b class="hr">Manage data</b></h1>
                </div>

                <!-- new row -->
                <div class="row"> 

                    <!-- 1st card of row -->
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <div class="card-header">
                                <h4 class="my-0 text-center font-weight-normal text-blue">Change password</h4>
                            </div>
                            <img class="card-img-top" src="img/password.png" alt="Card image cap">
                            <div class="card-body">
                                <p class="card-text">Change your password</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col text-center ">
                                        <a href="changePassDoc.php"><button type="button" class="btn btn-primary">Change</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- end of row  -->

            </div><!-- end of container -->
        </div><!-- end of album -->
    </main>

    <!-- footer -->
    <footer class="text-blue bg-light">
        <div class="container">
            <p> JBB Bałdyga Medical Clinic 2020 &copy;</p>
            <p> Site made by: Gracjan Wiśniewski</p>
        </div>
    </footer>

    <!-- Bootstrap things  -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-slim.min.js"><\/script>')</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js%22%3E"></script>
    <script src="js/holder.min.js"></script> 

  </body>
</html>
