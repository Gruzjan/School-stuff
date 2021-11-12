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

//add patient, but first check if name and surname dont contain any special chars, alert about results
if(isset($_POST['btnAddPatient'])){
    $addName = ucfirst($_POST['addName']);
    $addSurname = ucfirst($_POST['addSurname']);
    $addStreet = $_POST['addStreet'];
    $addStreetNum = $_POST['addStreetNum'];
    if($_POST['addApartment'] == ""){$addApartment = "NULL";}else{$addApartment = $_POST['addApartment'];};
    $addZip = $_POST['addZip'];
    $addCity = ucfirst($_POST['addCity']);
    $addPesel = $_POST['addPesel'];
    $addDate = $_POST['addDate'];
    $addSex = $_POST['addSex'];

    $forbidden = "/['1234567890!^£$%&*()}{@#~?><>,|=+¬-]/";

    if(preg_match($forbidden, $addName) || preg_match($forbidden, $addSurname) || preg_match($forbidden, $addStreet) || preg_match($forbidden, $addCity)){
        echo "<div class='alert alert-fixed alert-danger' role='alert'>Name, surname, street and city can't contain any special characters</div>";
    }elseif(!is_numeric($addPesel) || strlen($addPesel) != 11){
        echo "<div class='alert alert-fixed alert-danger' role='alert'>Please enter correct PESEL number</div>";
    }elseif($addStreetNum < 0 || $addApartment < 0){
        echo "<div class='alert alert-fixed alert-danger' role='alert'>Please enter correct street and/or flat number</div>";
    }else{
        $query = "INSERT INTO pacjenci(imie, nazwisko, ulica, nrDomu, nrMieszkania, kodPocztowy, miasto, pesel, dataUr, plec) VALUES ('$addName', '$addSurname', '$addStreet', '$addStreetNum', $addApartment, '$addZip', '$addCity', '$addPesel', '$addDate', '$addSex')";
        $statement = mysqli_query($connection, $query);

        if($statement){
            echo '<div class="alert alert-fixed alert-success" role="alert">Patient added successfully</div>';
        }else{
            echo '<div class="alert alert-fixed alert-danger" role="alert">Something went wrong</div>';
        }
    }
}

//print patients
$query = "SELECT imie, nazwisko, pesel, id FROM pacjenci;";
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
        <!-- add patient form -->
        <div class='form-center'>
            <h1 class="header">Add a new patient</h1>

            <form action="" method="post" class='form-addPatient border border-danger rounded'>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="addName">First name</label>
                        <input type="text" class="form-control" name="addName" placeholder="Name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="addSurname">Last name</label>
                        <input type="text" class="form-control" name="addSurname" placeholder="Surname" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="addStreet">Street</label>
                    <input type="text" class="form-control" name="addStreet" placeholder="Konrada Guderskiego" required>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="addStreetNum">Street number</label>
                        <input type="number" class="form-control" name="addStreetNum" placeholder="66" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="addApartment">Flat, etc. number</label>
                        <input type="number" class="form-control" name="addApartment" placeholder="Optional">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="addZip">Zip</label>
                        <input type="text" class="form-control" name="addZip" placeholder="80-180" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="addCity">City</label>
                        <input type="text" class="form-control" name="addCity" placeholder="Gdansk" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="addPesel">PESEL</label>
                        <input type="text" class="form-control" name="addPesel" placeholder="08251358116" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="addSex">Sex</label>
                        <select name="addSex" class='form-control' required>
                            <option value="M">Male</option>
                            <option value="K">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="addDate">Birth Date</label>
                        <input type="date" class="form-control" name="addDate" placeholder="" required>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name='btnAddPatient'>Add</button>
            </form>


            
        <!-- if query was executed succesfully print results -->
        <div class="text-center table-center">
            <?php if($statement){?>
                <table class='text-center table table-striped'><thead><tr class="text-red"><th scope="col">#</th><th scope="col">Name</th><th scope="col">Surname</th><th scope="col">PESEL</th><th scope="col">Modify</th></tr></thead><tbody>
                <?php $count = 0; while ($row = mysqli_fetch_array($statement)){
                    $count++;
                    echo "<tr class='text-blue'><th scope='row' class='text-red'>$count</th><td>{$row['imie']}</td><td>{$row['nazwisko']}</td><td>{$row['pesel']}</td><td><form action='modifyPatient.php' method='post'><button class='btn btn-sm btn-outline-primary' type='submit' name='btnModifyPatient' value='{$row['id']}'>Modify</button></form></td></tr>";
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
