<?php
$Servername = "192.168.11.30:3306";
$Username = "medewerker";
$Password = "Luckiness-Zebra-Carefully8";
$Dbname = "userstory_bedrijfsgegevens";
// maak verbinding met de database
$conn = new mysqli($Servername, $Username, $Password, $Dbname);
// controleer de verbinding
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT
            `ID`,
            `Bedijf naam`,
            `Voornaam`,
            `Tussenvoegsel`,
            `Achternaam`,
            `Functie`,
            `Email`,
            `Telefoon nummer`,
            `Address`
        FROM `Klanten`";

$result = $conn->query($sql);

if (!$result) {
    die("SQL-fout: " . $conn->error);
}

?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Contacten Overzicht</title>
</head>
<body>

<h1>Database Gegevens</h1>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Bedrijfnaam</th>
        <th>Voornaam</th>
        <th>Tussenvoegsel</th>
        <th>Achternaam</th>
        <th>Functie</th>
        <th>Email</th>
        <th>Telefoonnummer</th>
        <th>Adres</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
echo "<tr>";
echo "<td>".$row['ID']."</td>";
echo "<td>".$row['Bedijf naam']."</td>";
echo "<td>".$row['Voornaam']."</td>";
echo "<td>".$row['Tussenvoegsel']."</td>";
echo "<td>".$row['Achternaam']."</td>";
echo "<td>".$row['Functie']."</td>";
echo "<td>".$row['Email']."</td>";
echo "<td>".$row['Telefoon nummer']."</td>";
echo "<td>".$row['Address']."</td>";
echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9'>Geen gegevens gevonden</td></tr>";
    }
    ?>

</table>

</body>
</html>

<?php
$conn->close();
?>
