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
    $modifyStreet = $_POST['modifyStreet'];
    $modifyStreetNum = $_POST['modifyStreetNum'];
    $modifyApartment = $_POST['modifyApartment'];
    $modifyZip = $_POST['modifyZip'];
    $modifyCity = ucfirst($_POST['modifyCity']);
    $modifyPesel = $_POST['modifyPesel'];
    $modifyDate = $_POST['modifyDate'];
    if($_POST['modifySex'] == ""){$modifySex = "";}else{$modifySex = $_POST['modifySex'];}

    if($modifyName != "" || $modifySurname != "" || $modifyStreet != "" || $modifyStreetNum != "" || $modifyApartment != "" || $modifyZip != "" || $modifyCity != "" || $modifyPesel != "" || $modifyDate != "" || $modifySex != ""){
        
        $forbidden = "/['1234567890!^£$%&*()}{@#~?><>,|=+¬-]/";
        //set query depending on filled fields
        $query = "UPDATE pacjenci SET ";
        
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
        if($modifyStreet != ""){
            if(preg_match($forbidden, $modifyStreet)){
                //check for forobidden chars
                echo "<div class='alert alert-fixed alert-danger' role='alert'>Name, surname, street and city can't contain any special characters</div>";
            }else{
            $query .= "ulica = '$modifyStreet', ";
            }
        }
        if($modifyStreetNum != ""){
            $query .= "nrDomu = '$modifyStreetNum', ";
        }
        if($modifyApartment != ""){
            $query .= "nrMieszkania = '$modifyApartment', ";
        }
        if($modifyZip != ""){
            $query .= "kodPocztowy = '$modifyZip', ";
        }
        if($modifyCity != ""){
            if(preg_match($forbidden, $modifyCity)){
                //check for robidden chars
                echo "<div class='alert alert-fixed alert-danger' role='alert'>Name, surname, street and city can't contain any special characters</div>";
                exit;
            }else{
            $query .= "miasto = '$modifyCity', ";
            }
        }
        if($modifyPesel != ""){
            $query .= "pesel = '$modifyPesel', ";
        }
        if($modifyDate != ""){
            $query .= "dataUr = '$modifyDate', ";
        }
        if($modifySex != ""){
            $query .= "plec = '$modifySex', ";
        }
        $query .= "id = '$id' WHERE id = '$id'";
        
        $statement = mysqli_query($connection, $query);
        
        if($statement){
            echo '<div class="alert alert-fixed alert-success" role="alert">Succesfully modified</div>';
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
                    <a href="patients.php"><button name="back" class="btn btn-primary">Back</button></a>
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
        <div class='form-center'>
            <h1 class="header">Modify the patient</h1>

            <form action="" method="post" class='form-modifyPatient border border-danger rounded'>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="modifyName">First name</label>
                        <input type="text" class="form-control" name="modifyName" placeholder="Name" >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="modifySurname">Last name</label>
                        <input type="text" class="form-control" name="modifySurname" placeholder="Surname" >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="modifyStreet">Street</label>
                    <input type="text" class="form-control" name="modifyStreet" placeholder="Konrada Guderskiego" >
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="modifyStreetNum">Street number</label>
                        <input type="number" class="form-control" name="modifyStreetNum" placeholder="66" >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="modifyApartment">Flat, etc. number</label>
                        <input type="number" class="form-control" name="modifyApartment" placeholder="12">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="modifyZip">Zip</label>
                        <input type="text" class="form-control" name="modifyZip" placeholder="80-180" >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="modifyCity">City</label>
                        <input type="text" class="form-control" name="modifyCity" placeholder="Gdansk" >
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="modifyPesel">PESEL</label>
                        <input type="text" class="form-control" name="modifyPesel" placeholder="08251358116" >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="modifySex">Sex</label>
                        <select name="modifySex" class='form-control' >
                            <option value="">The same</option>
                            <option value="M">Male</option>
                            <option value="K">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="modifyDate">Birth Date</label>
                        <input type="date" class="form-control" name="modifyDate" placeholder="" >
                    </div>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" value="<?php $id = $_POST['btnModifyPatient']; echo "$id"?>" name='btnModify'>Modify</button>
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