<?php
$connection = mysqli_connect("localhost", "root", "", "baza");
//mysql_select_db("baza", $connection);

$data = $_POST['data'];
$osoby = $_POST['osoby'];
$tel = $_POST['tel'];
echo("Dodano rezerwacje do bazy");

$query = "INSERT INTO rezerwacje(data_rez, liczba_osob, telefon) VALUES ('$data', $osoby, $tel)";
$statement = mysqli_query($connection, $query);

mysqli_close($connection);

?>