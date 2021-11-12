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

//if registrant with this login and password is found set session variables, else move to doctor's site
$login = $_SESSION["login"];
$pass = $_SESSION["pass"];
$query = "SELECT * FROM rejestratorzy WHERE login = '$login' AND haslo = '$pass'";
$statement = mysqli_query($connection, $query);

if($row = (mysqli_fetch_array($statement))){
    $name = $row['imie'];
    $surname = $row['nazwisko'];
    $regId = $row['id'];
}else{
    header("Location: doctor.php");
}

//adding data
if(isset($_POST['btnAdd'])){
    $addPatient = $_POST['addPatient'];
    $addDoctor = $_POST['addDoctor'];
    $addDate = $_POST['addDate'];
    $ymd = "";
    $hour = "";
    
    for($i = 0; $i < 10; $i++){
        $ymd .= $date[$i];
    }
    for($i = 11; $i < 16; $i++){
        $hour .= $date[$i];
    }
    $strdate = $ymd." ".$hour;
    $query = "SELECT * FROM wizyty WHERE data LIKE '$ymd%' and lekarzId = '$addDoctor'";
    $statement = mysqli_query($connection, $query);
    if(mysqli_num_rows($statement) >= 10){
        echo "<div class='alert alert-fixed alert-danger' role='alert'>This doc can't take anymore patients today</div>";
        exit;
    }
    
    $query = "SELECT * FROM wizyty WHERE data LIKE '$strdate%' and lekarzId = '$addDoctor'";
    $statement = mysqli_query($connection, $query);
    if(mysqli_num_rows($statement) > 0){
        echo "<div class='alert alert-fixed alert-danger' role='alert'>This doc already has an appointment at this time</div>";
        exit;
    }
    
    $query = "INSERT INTO wizyty (pacjentid, lekarzid, rejestratorid, data) VALUES ('$addPatient', '$addDoctor', '$regId', '$addDate')";
    $statement = mysqli_query($connection, $query);
    if($statement){
        echo '<div class="alert alert-fixed alert-success" role="alert">Succesfully added</div>';
    }
    else{
        echo '<div class="alert alert-fixed alert-danger" role="alert">Something went wrong</div>';
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
                    <a href="appointmentsDoc.php"><button name="back" class="btn btn-primary">Back</button></a>
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

    <main role='main'>
        <!-- add apointment form -->

        <h1 class="header">Add an appointment</h1>
        <form action="" method="post" class="form-modify align-middle border border-danger rounded">
            <p class='text-blue'>All fields are required.</p>
            <select class="form-control" name="addPatient">
                <?php
                    include "connect.php";
                    $connection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
                    $statement = mysqli_query($connection, "SELECT * FROM pacjenci");
                    while ($row=mysqli_fetch_array($statement)){
                        ?>
                            <option value="<?php echo $row['id'];?>"> <?php echo $row['imie']." ".$row['nazwisko']."; ".$row['pesel'];?></option>
                        <?php
                    }
                    mysqli_close($connection);
                ?>
            </select><br>
            <select class="form-control" name="addDoctor">
                <?php
                    include "connect.php";
                    $connection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
                    $statement = mysqli_query($connection, "SELECT * FROM lekarze");
                    while ($row=mysqli_fetch_array($statement)){
                        ?>
                            <option value="<?php echo $row['id'];?>"> <?php echo $row['imie']." ".$row['nazwisko']."; ".$row['tytul'];?></option>
                        <?php
                    }
                    mysqli_close($connection);
                ?>
            </select><br>
            <input class="form-control" type="datetime-local" name="addDate"><br>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name='btnAdd'>Add</button>
        </form>

            
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