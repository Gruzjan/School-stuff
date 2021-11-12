<?php
    setcookie("odwiedziny", "witamy", time() + 300);
    if(isset($_POST['btn'])){
        $_COOKIE['odwiedziny'] = $_POST['value'];
    }
    echo $_COOKIE['odwiedziny'];
?>

<form action="" method="post">
    <input name="value" type="text">
    <button name="btn" type="submit">aktualizuj</button>
</form>