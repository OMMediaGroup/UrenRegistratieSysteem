<?php
$Servername = "localhost";
$Username = "root";
$Password = "";
$Dbname = "userstory_bedrijfsgegevens";
// maak verbinding met de database
$conn = new mysqli($Servername, $Username, $Password, $Dbname);
// controleer de verbinding
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Hello world! klanten.php...";
?>