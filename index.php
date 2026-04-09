<?php
echo "Hello world! index.php Eliezel;"
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Database Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="./index.html" id="homeLink">home</a></li>
            <li><a href="./medewerkers.html">medewerkers</a></li>
            <li><a href="./klanten.html">klanten</a></li>
            <li><a href="./werkzaamheden.html">werkzaamheden</a></li>
            <li><a href="./uren.html">uren</a></li>
            <li><a href="./werkgevers.html">werkgevers</a></li>
            <li><a href="./opdrachten.html">opdrachten</a></li>
        </ul>
        <div class="nav-actions">
            <input type="text" id="search" placeholder="Zoeken..." onkeypress="zoekPagina(event)">
            <button class="login-trigger" onclick="openLogin()">log in</button>
        </div>
    </nav>
</header>

<main>
    <div class="content">
        <div id="loginPopup" class="popup">
            <div class="popup-content">
                <span onclick="closeLogin()" class="close">&times;</span>
                <h3>log in</h3>
                <div class="login-field">
                    <label>username:</label>
                    <input type="text">
                </div>
                <div class="login-field">
                    <label>wachtwoord:</label>
                    <input type="password">
                </div>
                <button class="login-btn">log in</button>
            </div>
        </div>

        <h2>welkom in de database</h2>
        <p>
            zoek, bekijk en beheer eenvoudig gegevens. <br>
            gebruik de zoekfunctie of navigeer via het menu om snel de juiste informatie te kunnen vinden. 
        </p>
    </div>
</main>

<script src="script.js"></script>
</body>
</html>