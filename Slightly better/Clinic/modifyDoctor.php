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
}else{
    header("Location: doctor.php");
}

if(isset($_POST['btnModify'])){
    //changing data
    $id = $_POST['btnModify'];
    $modifyName = ucfirst($_POST['modifyName']);
    $modifySurname = ucfirst($_POST['modifySurname']);
    $modifyTitle = $_POST['modifyTitle'];
    $modifySpecialization = $_POST['modifySpecialization'];


    if($modifyName != "" || $modifySurname != "" || $modifyTitle != "" || $modifySpecialization != ""){
        
        $forbidden = "/['1234567890!^£$%&*()}{@#~?><>,|=+¬-]/";
        //set query depending on filled fields
        $query = "UPDATE lekarze SET ";
        
        if ($modifyName != ""){
            if(preg_match($forbidden, $modifyName)){
                //check for forobidden chars
                echo "<div class='alert alert-fixed alert-danger' role='alert'>Name, surname, street and city can't contain any special characters</div>";
            }else{
                $query .= "imie = '$modifyName', ";
            }
        }
        if($modifySurname != ""){
            if(preg_match($forbidden, $modifySurname)){
                //check for forobidden chars
                echo "<div class='alert alert-fixed alert-danger' role='alert'>Name, surname, street and city can't contain any special characters</div>";
            }else{
                $query .= "nazwisko = '$modifySurname', ";
            }
        }
        if($modifyTitle != ""){
            $query .= "tytul = '$modifyTitle', ";
        }
        if($modifySpecialization != ""){
            $query .= "specjalizacja = '$modifySpecialization', ";
        }
        $query .= "id = '$id' WHERE id = '$id'";
        
        $statement = mysqli_query($connection, $query);
        
        if($statement){
            echo '<div class="alert alert-fixed alert-success" role="alert">Succesfully modified</div>';
            echo $query;
        }else{
            echo '<div class="alert alert-fixed alert-danger" role="alert">Something went wrong</div>';
        }

    }else{
        echo '<div class="alert alert-fixed alert-danger" role="alert">Fill at least one field</div>';
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
                    <a href="doctors.php"><button name="back" class="btn btn-primary">Back</button></a>
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
        <!-- modify doctor form -->

        <h1 class="header">Modify the doctor</h1>
        <form action="" method="post" class="form-modify align-middle border border-danger rounded">
            <p class='text-blue'>At least one field is required.</p>
            <input type="text" class="input-lg form-control" name="modifyName"  placeholder="Name" ><br>
            <input type="text" class="input-lg form-control" name="modifySurname" placeholder="Surname" ><br>
            <input type="text" class="input-lg form-control" name="modifyTitle"  maxlength="80" placeholder="Title" ><br>
            <input type="text" class="input-lg form-control" name="modifySpecialization"  maxlength="100"  placeholder="Specialization" ><br>

            <button class="btn btn-lg btn-primary btn-block" type="submit" value="<?php echo $_POST['btnModifyDoctor'];?>" name='btnModify'>Modify</button>
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