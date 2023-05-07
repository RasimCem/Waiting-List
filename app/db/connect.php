<?php
function getDBConnection()
{
    try {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "waiting-list";
        $conn = null;
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch (Exception $e) {
        die("Connection failed!");
    }
}

?>