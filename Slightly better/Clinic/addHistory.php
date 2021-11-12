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
}else{
    header("Location: registrant.php");
}

//adding data
if(isset($_POST['btnAdd'])){
    $appointmentId = $_POST['btnAdd'];
    $addInterview = ucfirst($_POST['addInterview']);
    $addDiagnosis = ucfirst($_POST['addDiagnosis']);
    $addPrescription = $_POST['addPrescription'];
    $addResearch = $_POST['addResearch'];
    $addRecommendations = $_POST['addRecommendations'];

    $query = "INSERT INTO historia(wizytaId, wywiad, rozpoznanie, opisRecepty, opisBadan, zalecenia) VALUES ('$appointmentId', '$addInterview', '$addDiagnosis', '$addPrescription', '$addResearch', '$addRecommendations') ";
    
    $statement = mysqli_query($connection, $query);
    
    if($statement){
        echo '<div class="alert alert-fixed alert-success" role="alert">Succesfully added</div>';
    }else{
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
        <!-- modify patient form -->
        <div class=''>
            <h1 class="header">Add history</h1>

            <form action="" method="post" class='form-addHistory border border-danger rounded'>
                <div class="form-group">
                    <label for="addInterview">Interview</label>
                    <textarea class="form-control" name="addInterview" maxlength="255" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="addPrescription">Prescription description</label>
                    <textarea class="form-control" name="addPrescription" maxlength="255" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="addResearch">Comissioned research</label>
                    <textarea class="form-control" name="addResearch" maxlength="255" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="addRecommendations">Recommendations</label>
                    <textarea class="form-control" name="addRecommendations" maxlength="255" rows="3" required></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="addDiagnosis" >Diagnosis</label>
                    <select class="form-control" name="addDiagnosis">
                    <?php
                        include "connect.php";
                        $connection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
                        $statement = mysqli_query($connection, "SELECT icd10 FROM choroby");
                        while ($row=mysqli_fetch_array($statement)){
                            ?>
                                <option value="<?php echo $row['icd10'];?>"> <?php echo $row['icd10'];?></option>
                            <?php
                        }
                        mysqli_close($connection);
                    ?>
                    </select>
                </div>

                <button class="btn btn-lg btn-primary btn-block" type="submit" value="<?php $id = $_POST['btnAddHistory']; echo "$id"?>" name='btnAdd'>Add</button>
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