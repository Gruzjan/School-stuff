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
$query = "SELECT * FROM lekarze WHERE login = '$login' AND haslo = '$pass'";
$statement = mysqli_query($connection, $query);

if($row = (mysqli_fetch_array($statement))){
    $name = $row['imie'];
    $surname = $row['nazwisko'];
    $id = $row['id'];
}else{
    header("Location: registrant.php");
}

//changing password
if(isset($_POST['btnChange'])){
    $pass = md5($_POST['pass']);
    $passNew = md5($_POST['passNew']);
    $passNewA = md5($_POST['passNewA']);
    
    $query = "SELECT * FROM rejestratorzy WHERE id = '$id'";
    $statement = mysqli_query($connection, $query);
    
    $row = mysqli_fetch_array($statement);
    
    //check all password requirements and alert about every case
    if($pass == "" || $passNew == "" || $passNewA == ""){
        echo '<div class="alert alert-fixed alert-danger" role="alert">All fields must be filled</div>';
    }else if($row['haslo'] != $pass){
        echo '<div class="alert alert-fixed alert-danger" role="alert">Wrong password</div>';
    }else if($passNew == $row['haslo']){
        echo "<div class='alert alert-fixed alert-danger' role='alert'>Current password can't be a new password</div>";
    }else if($passNew != $passNewA){
        echo '<div class="alert alert-fixed alert-danger" role="alert">Passwords must match</div>';
    }else if(strlen($_POST['passNew']) < 8){
        echo '<div class="alert alert-fixed alert-danger" role="alert">New password is too short</div>';
    }else if(!preg_match('/[A-ZĄĆĘŁŃÓŚŹŻ]/', $_POST['passNew'])){
        echo '<div class="alert alert-fixed alert-danger" role="alert">New password must contain at least 1 capital letter</div>';
    }else if(!preg_match('/[0-9]/', $_POST['passNew'])){
        echo '<div class="alert alert-fixed alert-danger" role="alert">New password must contain at least 1 number</div>';
    }else if($passNew == $passNewA && $row['haslo'] == $pass){
        $query = "UPDATE lekarze SET haslo = '$passNew' WHERE login = '$login'";
        $statement = mysqli_query($connection, $query);
        if($statement){
            echo '<div class="alert alert-fixed alert-success" role="alert">Password changed succesfully</div>';
            $_SESSION['pass'] = $passNew;
        }else{
            echo '<div class="alert alert-fixed alert-danger" role="alert">Wrong password or login</div>';
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

    <main role='main'>
        <div class='form-center'>
            <!-- form password-->
            <form action="" method="post" class="form-modify border border-danger rounded">
                <h1 class="h3 mb-3 text-red font-weight-normal">Change password</h1>
                <p class="text-black">Must contain min. 8 characters, 1 number, 1 special character and one capital letter.</p>
                <input type="password" class="input-lg form-control" name="pass"  placeholder="Password" autocomplete="off" required><br>
                <input type="password" class="input-lg form-control" name="passNew" placeholder="New password" autocomplete="off" required><br>
                <input type="password" class="input-lg form-control" name="passNewA"  placeholder="Repeat new password" autocomplete="off" required><br>

                <button class="btn btn-lg btn-primary btn-block" type="submit" name='btnChange'>Change</button>
            </form>
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