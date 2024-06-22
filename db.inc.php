<?php
$dsn =  "mysql:host=localhost;dbname=s30574";
$dbusername = "s30574";
$dbpassword = "Dom.Dora";

try{
    $pdo = new PDO( $dsn, $dbusername, $dbpassword );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "connection failed: " . $e->getMessage();
}


