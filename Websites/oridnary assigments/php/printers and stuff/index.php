<!DOCTYPE HTML>
<html>
<head>
    <title>Drukarki</title>
    <meta charset="UTF-8">
    <script>
        function szukaj(e) {
            
            var filter = e.value.toUpperCase();
            var table = document.getElementById("drukarki");
            var tr = table.getElementsByTagName("tr");

            for (var i = 0; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    var producent = td.textContent;
                    if (producent.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }

        }
    </script>
</head>
<body style="text-align: center;">

    <h2>Drukarki</h2>
    <input oninput="szukaj(this)" type="text"><br><br>
    <table id="drukarki" style="margin-left: auto; margin-right: auto;">
        <tr> <th>Producent</th> <th>Model</th> <th>Cena</th> <th>L. komp. tuszy</th> </tr>
        <?php
            $connection = mysqli_connect("localhost", "root", "", "baza");
            $result = mysqli_query($connection, "SELECT symbol, producent, model, cena, symbol_tuszu FROM drukarki;");
            while($list = mysqli_fetch_array($result)){
                $cnt = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM tusze where symbol = '{$list['symbol_tuszu']}';"));
                echo "<tr> <td>{$list['producent']}</td> <td><a href='drukarka.php?symbol={$list['symbol']}'>{$list['model']}</a></td> <td>{$list['cena']} zł</td> <td>$cnt</td> </tr>";
            }
        ?>
    </table><br>
    <a href="dt.php">Dodaj tusz</a> 
    <a href="dd.php">Dodaj drukarkę</a>

</body>
</html>