<!DOCTYPE HTML>
<html>
<head>
    <title>Drukarka <?php echo($_GET['symbol'])?></title>
    <meta charset="UTF-8">
</head>
<body style="text-align: center;">

    <h2>Drukarka <?php echo($_GET['symbol'])?></h2>
    <table style="margin-left: auto; margin-right: auto;">
        <tr> <th>Symbol</th> <th>Producent</th> <th>Model</th> <th>Symbol tuszu</th> <th>Rozmiar papieru</th> <th>Cena</th></tr>
        <?php
            $connection = mysqli_connect("localhost", "root", "", "baza");
            $result = mysqli_query($connection, "SELECT * FROM drukarki where symbol = '{$_GET['symbol']}';");
            while($list = mysqli_fetch_array($result)){
                echo "<tr> <td>{$list['symbol']}</td> <td>{$list['producent']}</td> <td>{$list['model']}</td> <td>{$list['symbol_tuszu']}</td> <td>{$list['rozmiar_papieru']}</td> <td>{$list['cena']} zł</td> </tr>";
            }
        ?>
    </table><br><br>

    <h2>Dostępne tusze do drukarki <?php echo($_GET['symbol'])?></h2>
    <table style="margin-left: auto; margin-right: auto;">
        <tr> <th>Producent</th> <th>Nazwa</th> <th>Symbol</th> <th>Cena</th></tr>
        <?php
            $result = mysqli_query($connection, "SELECT producent, nazwa, symbol, cena FROM tusze where symbol = (select symbol_tuszu from drukarki where symbol = '{$_GET['symbol']}');");
            while($list = mysqli_fetch_array($result)){
                echo "<tr> <td>{$list['producent']}</td> <td>{$list['nazwa']}</td> <td>{$list['symbol']}</td> <td>{$list['cena']} zł</td> </tr>";
            }
        ?>
    </table><br><br>
</body>
</html>