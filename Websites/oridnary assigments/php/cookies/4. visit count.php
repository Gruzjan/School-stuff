<?php
    if(!isset($_COOKIE['count'])){
        setcookie("count", 0, time()+3600);
        $_COOKIE['count'] = 0;
    }
?>
    <form action="4++.php" method="post">
        <input type="submit">
    </form>
<?php
    echo $_COOKIE['count'];
?>