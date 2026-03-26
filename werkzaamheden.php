<?php
$host = '192.168.11.30:3306'; // IP van je Ubuntu server
$db   = 'userstory_bedrijfsgegevens';
$user = 'medewerker';
$pass = 'Luckiness-Zebra-Carefully8'; 

$rijen = []; 

try {
    // Verbinding maken met de database
    $options = [PDO::ATTR_TIMEOUT => 5, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    // Let op: :3306 hoeft meestal niet in de host string als het standaard is, maar mag wel.
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$db;charset=utf8mb4", $user, $pass, $options);

    $stmt = $pdo->query("SELECT * FROM Werkzaamheden");
    $rijen = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<div class='alert alert-danger no-print'>Fout: " . $e->getMessage() . "</div>";
}
?>

