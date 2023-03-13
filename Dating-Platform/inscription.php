<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>My_meetic</title>
</head>

<body>
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

        $add_user = new userDatabase();
        $add_user->addUser();
        ?>
        
        <fieldset id="fieldset-inscription">
             <h1>Inscription</h1>
        <img id="img-form" width="179" height="54" src="misc/meetic-blanc.png" alt="logo-meetic">

            <form action="" method="POST">
                <br>
                <div>
                    <label for="nom">Nom</label>
                    <input class="input-inscription" type="text" name="nom" id="nom" maxlength="20" required>
                </div>
                <br>
                <div>
                    <label for="prenom">Prénom</label>
                    <input class="input-inscription" type="text" name="prenom" id="prénom" maxlength="20" required>
                </div>
                <br>
                <div>
                    <label for="date_de_naissance">Date de naissance</label>
                    <input  type="date" id="date" name="date_de_naissance" required>
                </div>
                <br>
                <div>
                    <label for="genre">Genre</label>
                    <input type="radio" name="genre" value="Homme" id="homme" required>Homme
                    <input type="radio" name="genre" value="Femme" id="femme" required>Femme
                    <input type="radio" name="genre" value="Autre" id="autre" required>Autre
                </div>
                <br>
                <div>
                    <label for="ville">Ville</label>
                    <input class="input-inscription" type="text" name="ville" id="ville" maxlength="20" required>
                </div>
                <br>
                <div>
                    <label for="email">Email</label>
                    <input class="input-inscription" type="email" name="email" id="email" required>
                </div>
                <br>
                <div>
                <label for="mot_de_passe">Mot de passe</label>
                <input class="input-inscription" type="password" id="mot_de_passe" name="mot_de_passe1" minlength="8" required>
                </div>
                <br>
                <div>
                <label for="comfirmation_mot_de_passe">Comfirmez votre mot de passe</label>
                <input class="input-inscription" type="password" id="comfirmation_mot_de_passe" name="mot_de_passe2" minlength="8" required>
                </div>
                <br>
                <br>
                <div>
                <label>Loisirs</label>
                <input type="checkbox" id="cinéma" value="Cinéma" name="loisirs1">Cinéma
                <input type="checkbox" id="sport" value="Sport" name="loisirs2">Sport
                <input type="checkbox" id="danse" value="Danse" name="loisirs3">Danse
                <input type="checkbox" id="voyage" value="Voyage" name="loisirs4">Voyage
                </div>
                <br>
                <br>
                <div>
                    <input id="submit-inscription-connexion" type="submit" value="S'inscrire" name="inscription">
                </div>
            </form>
        </fieldset>
    </main>
    <footer id="footer-inscription">
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