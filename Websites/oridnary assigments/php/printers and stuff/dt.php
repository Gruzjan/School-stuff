<?php

    if(isset($_POST['sbmt']) && $_POST['producent'] != "" && $_POST['nazwa'] != "" && $_POST['symbol_tuszu'] != "" && $_POST['cena'] != ""){
        $query = "insert into tusze(producent, nazwa, symbol, cena) values ('{$_POST['producent']}', '{$_POST['nazwa']}', '{$_POST['symbol_tuszu']}', '{$_POST['cena']}')";
        $connection = mysqli_connect("localhost", "root", "", "baza");
        mysqli_query($connection, $query);
        header('location: dt.php');
    }
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Dodaj tusz</title>
    <meta charset="UTF-8">
</head>
<body>
    <h2>Dodaj tusz</h2>
    <form method="post" action="">
        Producent: <input type="text" name="producent" maxlength="30" size="35"><br>
        Nazwa: <input type="text" name="nazwa" maxlength="30" size="35"><br>
        Symbol: <input type="text" name="symbol_tuszu" maxlength="10" size="15"><br>
        Cena: <input type="number" name="cena" min="0" step="0.01"><br>
        <input type="submit" value="Dodaj" name="sbmt">
    </form>
    
</body>
</html>