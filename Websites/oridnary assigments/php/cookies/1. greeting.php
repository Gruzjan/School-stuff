<?php
    setcookie("odwiedziny", "witamy", time() + 300);
    if(!isset($_COOKIE["odwiedziny"])){
        echo "<p><i>Dzien dobry, nasza strona obsluguje ciasteczka</i></p>";
    }else{
        echo "<p><b>Witaj ponownie</b></p>";
    } 
?>