<?php
session_start();
if(isset($_POST['btnDel'])){
    $temp = $_POST['btnDel'];
    unset($_SESSION["$temp"]);
    header("Refresh 0");
}
if(isset($_POST['clear'])){
    $_SESSION = array();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>koszyk abcdef</title>
</head>
<body>
    <h1>Koszyk</a><br>
    <?php
        if(isset($_SESSION['A']))
            echo "<table><tr><td>A</td><td> <form action='' method='post'><button type='submit' value='A' name='btnDel'>usun</button></form> </td></tr></table>";
        if(isset($_SESSION['B']))
            echo "<table><tr><td>B</td><td> <form action='' method='post'><button type='submit' value='B' name='btnDel'>usun</button></form> </td></tr></table>";
        if(isset($_SESSION['C']))
            echo "<table><tr><td>C</td><td> <form action='' method='post'><button type='submit' value='C' name='btnDel'>usun</button></form> </td></tr></table>";
        if(isset($_SESSION['D']))
            echo "<table><tr><td>D</td><td> <form action='' method='post'><button type='submit' value='D' name='btnDel'>usun</button></form> </td></tr></table>";
        if(isset($_SESSION['E']))
            echo "<table><tr><td>E</td><td> <form action='' method='post'><button type='submit' value='E' name='btnDel'>usun</button></form> </td></tr></table>";
        if(isset($_SESSION['F']))
            echo "<table><tr><td>F</td><td> <form action='' method='post'><button type='submit' value='F' name='btnDel'>usun</button></form> </td></tr></table>";
        

        if(!isset($_SESSION['A']) && !isset($_SESSION['B']) && !isset($_SESSION['C']) && !isset($_SESSION['D']) && !isset($_SESSION['E']) && !isset($_SESSION['F'])){
            echo "<a href='sklep.php'><button>sklep</button></a>";
        }else{
            echo "<table><tr><td> <a href='sklep.php'><button>sklep</button></a> </td>";
            echo "<td> <form action='' method='post'><button type='submit' name='kup'>kup</button></form> </td></tr></table>";
            echo "<form action='' method='post'><button type='submit' name='clear'>wyczysc koszyk</button></form>";
        }

        if(isset($_POST['kup'])){
            echo "<h3>Kupiono: <br>";
            if(isset($_SESSION['A']))
                echo "A <br>";
            if(isset($_SESSION['B']))
                echo "B <br>";
            if(isset($_SESSION['C']))
                echo "C <br>";
            if(isset($_SESSION['D']))
                echo "D <br>";
            if(isset($_SESSION['E']))
                echo "E <br>";
            if(isset($_SESSION['F']))
                echo "F <br>";
            header("refresh:5;url=sklep.php");
            $_SESSION = array();
        }
        
    ?>
</body>
</html>