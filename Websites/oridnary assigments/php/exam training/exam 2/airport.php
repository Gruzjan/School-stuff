<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Odloty samolotów</title>
    <link rel="stylesheet" type="text/css" href="styl6.css">
</head>
<body>
    <div id="b1">
        <h2>Odloty z lotniska</h2>
    </div>

    <div id="b2">
        <img src="zad6.png" alt="logotyp">
    </div>

    <div id="main">
        <h4>tabela odlotów</h4>
        <table>
            <tr> <th>lp.</th> <th>numer rejsu</th> <th>czas</th> <th>kierunek</th> <th>status</th> </tr>
            <?php
                $connection = mysqli_connect("localhost", "root", "", "egzamin");
                $query = "SELECT id, nr_rejsu, czas, kierunek, status_lotu FROM odloty order by czas desc";
                $rs = mysqli_query($connection, $query);
                while($list = mysqli_fetch_array($rs)){
                    echo "<tr> <td>{$list['id']}</td> <td>{$list['nr_rejsu']}</td> <td>{$list['czas']}</td> <td>{$list['kierunek']}</td> <td>{$list['status_lotu']}</td> </tr>";
                }
                mysqli_close($connection);
            ?>
        </table>
    </div>

    <div id="s1">
        <a href="Gracjan Wisniewski/kw1.jpg" target="_blank">Pobierz obraz</a>
    </div>

    <div id="s2">
        <?php
            if(!isset($_COOKIE['visit'])){
                setcookie("visit", time() + 3600);
                echo "<p><i>Dzień Dobry! Sprawdź regulamin naszej strony</i></p>";
            }else{
                echo "<p><b>Miło nam, że nas znowu odwiedziłeś</b></p>";
            }
        ?>
    </div>

    <div id="s3">
        Autor: Gracjan Wiśniewski
    </div>
</body>
</html>