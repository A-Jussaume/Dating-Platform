<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>My_meetic</title>
</head>

<body>
    <?php
    session_start();
    ?>
    <header>
        <nav class="nav">
            <img id="img-nav" width="239" height="72" src="misc/meetic-blanc.png" alt="logo-meetic">
            <div class="button-nav">
                <input type="button" value="Inscription" name="Inscription" id="inscription" onclick="window.location.href='inscription.php'">
                <input type="button" value="Se connecter" name="Connexion" id="connexion" onclick="window.location.href='connexion.php'">
            </div>
        </nav>
    </header>
    <main>

        <?php
        require_once('model/userDatabase.php');

        $user_verification = new userDatabase();
        $user_verification->userVerification();
        ?>

        <fieldset id="fieldset-connexion">
             <h1>Connexion</h1>
        <img id="img-form" width="179" height="54" src="misc/meetic-blanc.png" alt="logo-meetic">

            <form action="#" method=POST>
                <br>
                <div>
                    <label for="email">Email</label>
                    <input class="input-inscription" type="mail" name="email" id="email" required>
                </div>
                <br>
                <div>
                <label for="mot_de_passe">Mot de passe</label>
                <input class="input-inscription" type="password" id="mot_de_passe" name="mot_de_passe" required>
                </div>
                <br>
                <br>
                <div>
                    <input id="submit-inscription-connexion" type="submit" value="Connexion">
                </div>          
            </form>
        </fieldset>
    </main>
    <footer id="footer-connexion">
        <div class="footer-nav">
            <a href="index.php"><strong>Accueil</strong></a>
            <a href="#"><strong>Nouveautés</strong></a>
            <a href="#"><strong>À propos</strong></a>
            <a href="#"><strong>Contacts</strong></a>
            <br>
            <p id="copyright">© MyMeetic.</p>
        </div>
    </footer>
</body>

</html>