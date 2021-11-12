<?php
if(isset($_POST['send'])){
    $file = fopen("comments.txt", "a");
    flock($file, LOCK_EX);
    if($_POST['nick'] != "" && $_POST['comm'] != ""){
        $nick = strip_tags($_POST['nick']);
        $comm = strip_tags($_POST['comm']);
        $date = date("Y-m-d | H:i:s");
        fwrite($file, "<b>$nick</b> $date <br><p>$comm</p><hr>");
    }
    flock($file, LOCK_UN);
    fclose($file);
    header('Location: ' . $_SERVER['PHP_SELF']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
</head>
<body>
    <form action="" method="post">
        Nick: <br> 
        <input type="text" name="nick"><br>
        <textarea name="comm" rows="4" cols="50">Your comment here</textarea><br>
        <button type="submit" name="send">Send</button>
    </form>
    <h2>Comments</h2>
    <?php
        $file = fopen("comments.txt", "r");
        if(filesize("comments.txt") != 0){
            $content = fread($file, filesize("comments.txt"));
            echo "<div style='width: 500px;'>$content<div>";
        }
        fclose($file);
    ?>
</body>
</html>