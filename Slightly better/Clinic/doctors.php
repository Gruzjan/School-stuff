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
    $id = $row['id'];
}else{
    header("Location: doctor.php");
}

//add doctor, but first check if name and surname dont contain any special chars, alert about results
if(isset($_POST['btnAddDoctor'])){
    $addName = ucfirst($_POST['addName']);
    $addSurname = ucfirst($_POST['addSurname']);
    $addTitle = $_POST['addTitle'];
    $addSpecialization = $_POST['addSpecialization'];

    $forbidden = "/['1234567890!^£$%&*()}{@#~?><>,|=+¬-]/";

    if(preg_match($forbidden, $addName) || preg_match($forbidden, $addSurname)){
        echo "<div class='alert alert-fixed alert-danger' role='alert'>Name and surname can't contain any special characters</div>";
    }else{
        $login = $addName[0].$addSurname[0].rand(10, 99);
        $pass = md5(rand(0,9).$addName."?");

        $query = "INSERT INTO lekarze(imie, nazwisko, tytul, specjalizacja, login, haslo) VALUES ('$addName', '$addSurname', '$addTitle', '$addSpecialization', '$login', '$pass')";
        $statement = mysqli_query($connection, $query);

        if($statement){
            echo '<div class="alert alert-fixed alert-success" role="alert">Doctor added successfully</div>';
        }else{
            echo '<div class="alert alert-fixed alert-danger" role="alert">Something went wrong</div>';
        }
    }
}

//print doctors
$query = "SELECT imie, nazwisko, tytul, specjalizacja, id FROM lekarze;";
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

  <body class='text-center center'>

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
                    <a href="registrant.php"><button name="back" class="btn btn-primary">Back</button></a>
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
    <div class='form-center'>
        <h1 class="header">Add a new doctor</h1>

        <form action="" method="post" class="form-add align-middle border border-danger rounded">
            <p class='text-blue'>Every field is required.</p>
            <input type="text" class="input-lg form-control" name="addName"  placeholder="Name" required><br>
            <input type="text" class="input-lg form-control" name="addSurname" placeholder="Surname" required><br>
            <input type="text" class="input-lg form-control" name="addTitle"  maxlength="80" placeholder="Title" required><br>
            <input type="text" class="input-lg form-control" name="addSpecialization"  maxlength="100"  placeholder="Specialization" required><br>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name='btnAddDoctor'>Add</button>
        </form>


            
        <!-- if query was executed succesfully print results -->
        <div class="text-center table-center">
            <?php if($statement){?>
                <table class='text-center table table-striped'><thead><tr class="text-red"><th scope="col">#</th><th scope="col">Name</th><th scope="col">Surname</th><th scope="col">Title</th><th scope="col">Specialization</th><th scope="col">Modify</th></tr></thead><tbody>
                <?php $count = 0; while ($row = mysqli_fetch_array($statement)){
                    $count++;
                    echo "<tr class='text-blue'><th scope='row' class='text-red'>$count</th><td>{$row['imie']}</td><td>{$row['nazwisko']}</td><td>{$row['tytul']}</td><td>{$row['specjalizacja']}</td><td><form action='modifyDoctor.php' method='post'><button class='btn btn-sm btn-outline-primary' type='submit' name='btnModifyDoctor' value='{$row['id']}'>Modify</button></form></td></tr>";
                }?>
                </thead></table>
            <?php }?>
        </div>
    </main><br><br>

    <!-- footer -->
    <footer class="text-blue bg-light">
        <div class="container">
            <p> JBB Bałdyga Medical Clinic 2020 &copy;</p>
            <p> Site made by: Gracjan Wiśniewski</p>
        </div>
    </footer>

</body>
</html>
