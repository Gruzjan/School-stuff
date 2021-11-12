<?php
session_start();
if(isset($_POST['sbmt'])){

    if(isset($_POST['A'])){
        $_SESSION['A'] = 1;
    }
    if(isset($_POST['B'])){
        $_SESSION['B'] = 1;
    }
    if(isset($_POST['C'])){
        $_SESSION['C'] = 1;
    }
    if(isset($_POST['D'])){
        $_SESSION['D'] = 1;
    }
    if(isset($_POST['E'])){
        $_SESSION['E'] = 1;
    }
    if(isset($_POST['F'])){
        $_SESSION['F'] = 1;
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sklep</title>
</head>
<body>
    <h1>Sklep abcdef</h1>
    <form action='' method='post'>
        A <input type="checkbox" name="A"><br>
        B <input type="checkbox" name="B"><br>
        C <input type="checkbox" name="C"><br>
        D <input type="checkbox" name="D"><br>
        E <input type="checkbox" name="E"><br>
        F <input type="checkbox" name="F"><br>
        <button type="submit" name='sbmt'>dodaj</button><br>
    </form>
    <a href='koszyk.php'><button>koszyk</button></a>
</body>
</html>