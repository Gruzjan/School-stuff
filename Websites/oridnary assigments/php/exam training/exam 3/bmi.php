<?php
$connection = mysqli_connect('localhost', 'root', '', 'egzamin');
$query = 'SELECT informacja, wart_min, wart_max FROM `bmi`';
$list = mysqli_query($connection, $query);

if(isset($_POST['btnSbmt'])){
    $connection2 = mysqli_connect('localhost', 'root', '', 'egzamin');
    $waga = $_POST['waga'];
    $wzrost = $_POST['wzrost'];
    if($waga != '' && $wzrost != ''){
        $bmi = ($waga / ($wzrost * $wzrost)) * 10000;
        if($bmi > 30)
            $przedzial = '4';
        elseif($bmi > 25)
            $przedzial = '3';
        elseif($bmi > 18)
            $przedzial = '2';
        else
            $przedzial = '1';

        $data = date('Y-m-d');
        $query2 = "INSERT INTO `wynik`(`bmi_id`, `data_pomiaru`, `wynik`) VALUES ($przedzial, '$data', $bmi)";
        $siema = mysqli_query($connection2, $query2);
        mysqli_close($connection2);
    }
}



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Twoje BMI</title>
    <link rel='stylesheet' type='text/css' href='styl3.css'>
</head>
<body>
    <div id="logo">
        <img src='wzor.png' alt='wzór BMI'>
    </div>

    <div id="baner">
        <h1>Oblicz swoje BMI</h1>
    </div>

    <div id="main">
        <table>
            <tr> <th>Interpretacja BMI</th> <th>Wartość minimalna</th> <th>Wartość maksymalna</th> </tr>
            <?php
                while($data = mysqli_fetch_array($list)){
                    echo "<tr><td>{$data['informacja']}</td><td>{$data['wart_min']}</td><td>{$data['wart_max']}</td></tr>";
                }
                mysqli_close($connection);
            ?>
        </table>
    </div>

    <div id="lewy">
        <h2>Podaj wagę i wzrost</h2>
        <form method='post' action=''>
            Waga: <input type="number" min=1 name="waga"><br>
            Wzrost w cm: <input type="number" min=1 name="wzrost"><br>
            <button type='submit' name='btnSbmt'>Oblicz i zapamiętaj wynik</button>
        </form><br>
        <?php
            if(isset($_POST['btnSbmt']) && $waga != '' && $wzrost != '')
                echo "Twoja waga: $waga; Twój wzrost: $wzrost;<br>BMI wynosi $bmi";
        ?>
    </div>

    <div id="prawy">
        <img src='rys1.png' alt='ćwiczenia'>
    </div>

    <div id="footer">
        Autor: Gracjan Wiśniewski <a href='kwerendy.txt'>Zobacz kwerendy</a>    
    </div>
</body>
</html>