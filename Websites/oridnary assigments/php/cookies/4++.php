<?php
    if(isset($_COOKIE['count'])){
        $val = $_COOKIE['count'] + 1;
        setcookie("count", $val); 
    }
    header("location: 4.php");
?>