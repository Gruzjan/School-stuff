<?php
    if(isset($_POST['sbmt']) && $_POST['symbol'] != '' && $_POST['producent'] != '' && $_POST['model'] != '' && $_POST['symbol_tuszu'] != '' && $_POST['rozmiar'] != '' && $_POST['cena'] != ''){
        $query = "insert into drukarki(symbol, producent, model, symbol_tuszu, cena, rozmiar_papieru) values ('{$_POST['symbol']}', '{$_POST['producent']}', '{$_POST['model']}', '{$_POST['symbol_tuszu']}', '{$_POST['cena']}', '{$_POST['rozmiar']}')";
        $connection = mysqli_connect("localhost", "root", "", "baza");
        mysqli_query($connection, $query);
        header('location: dd.php');
    }
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Dodaj drukare</title>
    <meta charset="UTF-8">
    <script>
        function duza(e){
            if(e.value.charAt(0) != e.value.charAt(0).toUpperCase())
                e.value = e.value.charAt(0).toUpperCase() + e.value.slice(1);  
        }
    </script>
</head>
<body>

    <h2>Dodaj drukarkę</h2><br>
    <form method="post" action="">
        Symbol: <input type="text" name="symbol" maxlength="30" size="35"><br>
        Producent: <input type="text" name="producent" maxlength="30" size="35" id="producent" onchange="duza(this)"><br>
        Model: <input type="text" name="model" maxlength="30" size="35" id="model" onchange="duza(this)"><br>
        Symbol tuszu: <select name="symbol_tuszu">
            <?php
                $connection = mysqli_connect("localhost", "root", "", "baza");
                $result = mysqli_query($connection, "select distinct symbol from tusze;");
                while($list = mysqli_fetch_array($result)){
                    echo "<option value='{$list['symbol']}'>{$list['symbol']}</option>";
                }
            ?>
        </select><br>
        Maks. rozmiar papieru: <select name="rozmiar">
            <option value="A4">A4</option>
            <option value="A3">A3</option>
            <option value="A3+">A3+</option>
        </select><br>
        Cena: <input type="number" name="cena" min="0" step="0.01"><br>
        <input type="submit" value="Dodaj" name="sbmt">
    </form>

</body>
</html>