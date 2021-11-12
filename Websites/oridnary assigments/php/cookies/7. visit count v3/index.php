<?php
    setcookie('visit', 1, time() + 120);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitors</title>
</head>
<body>
    <?php
        $file = fopen("count.txt", "r");
        flock($file, LOCK_EX);
        if(filesize("count.txt") != 0){
            $content = fread($file, filesize("count.txt"));
            echo "<b>Liczba odwiedzin: </b>";
            foreach(str_split($content) as $val){
                echo "<img src='$val.gif'>";
            }
            if(!isset($_COOKIE['visit'])){
                fclose($file);
                $file = fopen("count.txt", "w");
                fwrite($file, $content + 1);
            }
        }
        flock($file, LOCK_UN);
        fclose($file);
    ?>
</body>
</html>