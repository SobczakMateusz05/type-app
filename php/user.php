<?php
require_once("connect.php");

$name = $_POST["name"];
$pass = $_POST["pass"];
$type= $_POST["type"];

$sql = "INSERT INTO osoby(imie, haslo, typ) VALUES('$name', '$pass', '$type')";

$result = $conn -> query($sql);

header("location:../adminpanel.php?user=1");