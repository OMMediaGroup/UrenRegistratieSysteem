<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Home - Urenregistratie Systeem</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #0a4f42;
        }

        /* Navigatie - exact hetzelfde als de andere pagina's */
        nav {
            background: #e8f7ee;
            padding: 15px;
            display: flex;
            justify-content: center;
            border-bottom: 3px solid #083c32;
        }

        nav .links a {
            margin: 0 18px;
            padding-right: 15px;
            color: #000;
            font-weight: bold;
            text-decoration: none;
            border-right: 2px solid #083c32;
        }

        nav .links a:last-child {
            border-right: none;
        }

        .container {
            background: #e8f7ee;
            margin: 40px auto;
            width: 80%;
            padding: 40px 30px;
            border-radius: 20px;
            border: 4px solid #083c32;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin: 0;
            font-size: 32px;
            color: #083c32;
        }

        h2 {
            margin-top: 30px;
            font-size: 24px;
            color: #083c32;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            color: #333;
            max-width: 700px;
        }

        /* Login popup styling (aangepast aan hetzelfde kleurenschema) */
        .popup {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(10, 79, 66, 0.85);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: #e8f7ee;
            padding: 30px 35px;
            border-radius: 20px;
            border: 4px solid #083c32;
            width: 420px;
            text-align: left;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .close {
            position: absolute;
            top: 12px;
            right: 20px;
            font-size: 32px;
            font-weight: bold;
            color: #083c32;
            cursor: pointer;
            line-height: 1;
        }

        .login-field {
            margin-bottom: 20px;
        }

        .login-field label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #083c32;
        }

        .login-field input {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #083c32;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .login-btn {
            background: #0a4f42;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
        }

        .login-btn:hover {
            background: #083c32;
        }

        .nav-actions {
            position: absolute;
            right: 40px;
            top: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .login-trigger {
            background: #0a4f42;
            color: white;
            padding: 8px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Navigatie - consistent met alle andere pagina's -->
<nav>
    <div class="links">
        <a href="index.php">home</a>
        <a href="medewerkers.php">medewerkers</a>
        <a href="klanten.php">klanten</a>
        <a href="werkzaamheden.php">werkzaamheden</a>
        <a href="uren.php">uren</a>
        <a href="werkgevers.php">werkgevers</a>
        <a href="opdrachten.php">opdrachten</a>
    </div>
    
    <!-- Extra navigatie-elementen uit jouw code (alleen de login-knop blijft over) -->
    <div class="nav-actions">
        <button class="login-trigger" onclick="openLogin()">log in</button>
    </div>
</nav>

<div class="container">

    <h1>Welkom in het Urenregistratie Systeem</h1>

    <div class="content">
        <h2>welkom in de database</h2>
        <p>
            zoek, bekijk en beheer eenvoudig gegevens.<br>
            gebruik de zoekfunctie of navigeer via het menu om snel de juiste informatie te kunnen vinden.
        </p>
    </div>

    <!-- Login popup (uit jouw code, volledig werkend en in hetzelfde design) -->
    <div id="loginPopup" class="popup">
        <div class="popup-content">
            <span onclick="closeLogin()" class="close">&times;</span>
            <h3 style="margin-top:0; color:#083c32;">Log in</h3>
            
            <div class="login-field">
                <label>username:</label>
                <input type="text" id="username" placeholder="Voer je gebruikersnaam in">
            </div>
            
            <div class="login-field">
                <label>wachtwoord:</label>
                <input type="password" id="password" placeholder="Voer je wachtwoord in">
            </div>
            
            <button class="login-btn" onclick="attemptLogin()">log in</button>
        </div>
    </div>

</div>

<script>
    // Login popup functies
    function openLogin() {
        document.getElementById("loginPopup").style.display = "flex";
    }

    function closeLogin() {
        document.getElementById("loginPopup").style.display = "none";
    }

    // Simpele login-demo (je kunt dit later vervangen door echte authenticatie)
    function attemptLogin() {
        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value.trim();
        
        if (username && password) {
            alert("✅ Ingelogd als: " + username + "\n\n(Deze demo-logic kun je later vervangen door een echte PHP-sessie/login-systeem)");
            closeLogin();
            // Hier kun je later window.location = "medewerkers.php"; zetten als je direct wilt doorsturen
        } else {
            alert("Vul zowel username als wachtwoord in.");
        }
    }
</script>

</body>
</html>