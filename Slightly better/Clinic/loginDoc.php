<?php
session_start();
require "connect.php"; 

error_reporting(E_ALL ^ E_NOTICE);

$connection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

if ($connection === false) {
    echo 'Błąd łączenia z bazą danych ' . mysqli_connect_errno() . ', opis błędu ' . mysqli_connect_error();
    exit;
}

$login = $_POST['login'];
$pass = md5($_POST['pass']);

//if logged in direct to correct site
if(isset($_SESSION['login'])){
    header("Location: doctor.php");
}else if($login != "" && $pass != ""){  //if form is filled set query
    $query= "SELECT * FROM lekarze WHERE login = '$login' AND haslo LIKE '$pass'";

    $statement = mysqli_query($connection, $query);
    //if logged in correctly assign essential data to session variables, if something went wrong display an alert
    if(mysqli_fetch_array($statement)){
        $site = "doctor";
        $_SESSION['login'] = $login;
        $_SESSION['pass'] = $pass;
        $_SESSION['site'] = $site;
    }else{
        echo '<div class="alert alert-fixed alert-danger" role="alert">Incorrect login or password</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="logo.png" type="image/png"/>

    <title>Log in</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet"/>

    <!-- my css -->
    <link href="css/login.css" rel="stylesheet"/>
</head>
<body class="text-center"> 

    <?php //if logged in direct to correct site
    if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
        $site = $_SESSION['site'];
        header("Location: $site.php");
    } else { ?>
        <div>
            <!-- form -->
            <h1 id="name" class="h3 mb-3 font-weight-normal">JBB Bałdyga Medical Clinic</h1>

            <form action="" method="post" class="form-signin border border-danger rounded">
                <img class="mb-4" src="img/logo.png" alt="logo" width="72" height="72">
                <h1 class="h3 mb-3 font-weight-normal text-blue">Welcome back, doc!</h1>

                <label for="inputLogin" class="sr-only">Login</label>
                <input type="login" id="inputLogin" name="login"class="form-control" placeholder="Login" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Password" required>

                <button class="btn btn-lg btn-primary btn-block" type="submit" name='btnLogIn'>Log in</button>
                <p class="mt-5 mb-3 text-muted">Made by: Gracjan Wiśniewski</p>
            </form>
        </div>
    <?php } ?>
    

</body>
</html>