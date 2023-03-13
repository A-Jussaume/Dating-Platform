<!DOCTYPE html>
<html lang="en">

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
                <form method="POST">
                <input class="input-compte" type="submit" value="Modifier compte" name="modifier-compte" id="modifier-compte">                
                <input type="submit" value="Déconnexion" name="déconnexion" id="deconnexion">
            </form> 
            </div>
        </nav>
    </header>
    <main>
    <?php
        require_once("model/userDatabase.php");
        $account = new userDatabase();
        $account->userMoficication();
        ?>
        <fieldset id="fieldset-mon-compte">
                <h1>Mon compte</h1>
            <img id="img-form" width="179" height="54" src="misc/meetic-blanc.png" alt="logo-meetic">

            <form method="POST">
            <?php
            echo "<p class='info-compte'>" . "Nom : " . $_SESSION['nom'] . "</p>" .
                 "<p class='info-compte'>" . "Prénom : " . $_SESSION['prenom'] . "</p>" .
                 "<p class='info-compte'>" . "Date de naissance : " . $_SESSION['date_de_naissance'] . "</p>" .
                 "<p class='info-compte'>" . "Genre : " . $_SESSION['genre'] . "</p>" .
                 "<p class='info-compte'>" . "Email : " . $_SESSION['email'] . "</p>" .
                 "<p class='info-compte'>" . "Loisirs : " . $_SESSION['loisirs'] . "</p>";               
            ?>
            </form>
        </fieldset>
    </main>
    <footer id="footer-compte">
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