<?php 
    if(!isset($_COOKIE['odwiedziny'])){
        setcookie("odwiedziny", 1, time()+3600);
    }
    else{
        $val = $_COOKIE['odwiedziny'] + 1;
        setcookie("odwiedziny", $val); 
        echo $_COOKIE['odwiedziny'];
    }
    
?>