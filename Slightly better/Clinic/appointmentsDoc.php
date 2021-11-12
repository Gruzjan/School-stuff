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
    $id = $row['id'];
}else{
    header("Location: registrant.php");
}

//find today's appointments
    $today = date("Y-m-d");
    $query = "SELECT pacjenci.id, pacjenci.imie, pacjenci.nazwisko, wizyty.id AS wizytaId FROM pacjenci JOIN wizyty ON wizyty.pacjentId = pacjenci.id WHERE wizyty.data LIKE '$today%' AND wizyty.lekarzId = '$id'";
    $statement = mysqli_query($connection, $query);

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
    <link href="css/queries.css" rel="stylesheet">
    
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
            
            <!-- navbar items  -->
            <ul class="navbar-nav mr-right">
                <li class="nav-item nav-btns">
                     <!-- back  -->
                    <a href="doctor.php"><button name="back" class="btn btn-primary">Back</button></a>
                </li>
                <li class="nav-item nav-btns">
                     <!-- logout  -->
                    <form action="" method="post" class="my-2 my-md-0">
                        <button name="logout" class="btn btn-primary">Logout</button>
                    </form>
                </li>
            </ul>

        </div>
    </nav>

    <main role="main">

        <h1 class='header'><?php echo "Your " . date("d.m.Y") . " appointments"; ?></h1>

        <!-- if query was executed succesfully print results -->
        <div class="text-center table-center">
        <?php if($statement){?>
            <table class='text-center table table-striped'><thead><tr class="text-red"><th scope="col">#</th><th scope="col">Name</th><th scope="col">Surname</th><th scope="col">View data</th><th scope="col">View history</th><th scope="col">Add history</th></tr></thead><tbody>
            <?php $count = 0; while ($row = mysqli_fetch_array($statement)){
                $count++;
                echo "<tr class='text-blue'><th scope='row' class='text-red'>$count</th><td>{$row['imie']}</td><td>{$row['nazwisko']}</td><td><form action='viewData.php' method='post'><button class='btn btn-sm btn-outline-primary' type='submit' name='btnViewData' value='{$row['id']}'>View</button></form></td><td><form action='viewHistory.php' method='post'><button class='btn btn-sm btn-outline-primary' type='submit' name='btnViewHistory' value='{$row['id']}'>View</button></form></td><td><form action='addHistory.php' method='post'><button class='btn btn-sm btn-outline-primary' type='submit' name='btnAddHistory' value='{$row['wizytaId']}'>Add</button></form></td></tr>";
            }?>
            </thead></table>
        <?php }?>
        </div>
    </main>

    <!-- footer -->
    <footer class="text-blue bg-light">
        <div class="container">
            <p> JBB Bałdyga Medical Clinic 2020 &copy;</p>
            <p> Site made by: Gracjan Wiśniewski</p>
        </div>
    </footer>

</body>
</html>
