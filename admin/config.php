<?php
$servername      = "127.0.0.1";
$username        = "root";
$password        = "admin";
$dbname          = "polling-2";
$site_url_suffix = "";


try {

    $conn = new PDO("mysql:host=$servername;dbname=" . $dbname, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    echo "<h2>Connection failed: " . $e->getMessage() . "</h2>";
    die();

}