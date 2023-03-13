<?php

class userDatabase
{

    private  $_db;


    public function __construct()
    {
        try {
            $this->_db = new pdo("mysql:host=localhost;dbname=my_meetic;charset=UTF8", "aurelien", "root", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }


    public function addUser()
    {
        if (isset($_POST["nom"]) and isset($_POST["prenom"]) and isset($_POST["date_de_naissance"]) and isset($_POST["genre"]) and isset($_POST["ville"]) and isset($_POST["email"]) or isset($_POST["loisirs1"]) or isset($_POST["loisirs2"]) or isset($_POST["loisirs3"]) or isset($_POST["loisirs4"]) and isset($_POST["mot_de_passe1"]) and isset($_POST["mot_de_passe2"])) {

            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];

            $date_de_naissance = $_POST['date_de_naissance'];
            $today = date("Y-m-d");
            $diff = date_diff(
                date_create($date_de_naissance),
                date_create($today));
            $age = $diff->format("%y");

            if ($age < 18) {

                echo "<p id='message-mineur'>" . "Inscription impossible : " . "site interdit au mineur" . "</p>";
                return;
            } elseif ($age > 120) {

                echo "<p id='message-date-de-naissance'>" . "Il semblerait que vous vous êtes tromper sur votre date de naissance, à moins que vous soyez immortel !" . "</p>";
                return;
            }

            $genre = $_POST['genre'];
            $ville = $_POST['ville'];
            $email = $_POST['email'];

            if (isset($_POST['loisirs1'])) {
                $loisirs1 = $_POST['loisirs1'];
            } else {
                $loisirs1 = NUll;
            }

            if (isset($_POST['loisirs2'])) {
                $loisirs2 = $_POST['loisirs2'];
            } else {
                $loisirs2 = NUll;
            }

            if (isset($_POST['loisirs3'])) {
                $loisirs3 = $_POST['loisirs3'];
            } else {
                $loisirs3 = NUll;
            }

            if (isset($_POST['loisirs4'])) {
                $loisirs4 = $_POST['loisirs4'];
            } else {
                $loisirs4 = NUll;
            }


            $mot_de_passe1 = $_POST['mot_de_passe1'];
            $mot_de_passe2 = $_POST['mot_de_passe2'];

            if ($mot_de_passe1 !== $mot_de_passe2) {

                echo "<p id='message-comfirmation-mot-de-passe'>" . "Veuillez comfirmer votre mot de passe !" . "</p>";
                return;
            }
            if ($mot_de_passe1 === $mot_de_passe2) {
                $pass_hache = password_hash($mot_de_passe2, PASSWORD_DEFAULT);


                $request = $this->_db->query("SELECT COUNT(id_membre) AS num FROM membre");
                $data = $request->fetch();
                $num1 = $data["num"];

                $request = $this->_db->query("INSERT INTO membre (nom, prenom, date_de_naissance, genre, ville, email, loisirs, mot_de_passe, date_inscription) 
                                        SELECT '$nom','$prenom','$date_de_naissance','$genre','$ville','$email','$loisirs1 $loisirs2 $loisirs3 $loisirs4', '$pass_hache',NOW() 
                                        WHERE NOT EXISTS (SELECT email FROM membre WHERE email = '$email')");

                $request = $this->_db->query("SELECT COUNT(id_membre) AS num FROM membre");
                $data = $request->fetch();
                $num2 = $data["num"];
            }

            if ($num1 == $num2) {

                echo "<p id='message-email'>" . "Inscription impossible : un compte utilise déjà cette adresse mail" . "<p/>";
            } elseif ($num2 > $num1) {


                echo "<p id='message-compte-créé'>" . "Votre compte a bien été créé " . $prenom . " " . $nom . "<br>" . "<br>" . "Redirection vers la page de connexion dans 5 secondes..." . "</p>";
                echo "<meta HTTP-EQUIV='REFRESH' content='5; url=connexion.php'>";
            }
        $request->closeCursor();
        }
    }


    public function userVerification()
    {
        if (isset($_POST['email']) and isset($_POST['mot_de_passe'])) {

            $email = $_POST['email'];
            $mot_de_passe = $_POST['mot_de_passe'];

            $request = $this->_db->prepare("SELECT * FROM membre WHERE email = :email");
            $request->execute(array(
                'email' => $email));

            $result = $request->fetch();           

            if (!$result) {
                echo "<p class='message-mot-de-passe-identifiant'>" . "Mauvais identifiant ou mot de passe" . "</p>";
            } else {
                $isPasswordCorrect = password_verify($mot_de_passe, $result['mot_de_passe']);
                if ($isPasswordCorrect) {

                    $_SESSION['id'] = $result['id_membre'];
                    $_SESSION['prenom'] = $result['prenom'];
                    $_SESSION['nom'] = $result['nom'];
                    $_SESSION['date_de_naissance'] = $result['date_de_naissance'];
                    $_SESSION['genre'] = $result['genre'];
                    $_SESSION['ville'] = $result['ville'];
                    $_SESSION['email'] = $result['email'];
                    $_SESSION['loisirs'] = $result['loisirs'];
                    $_SESSION['mot_de_passe'] = $result['mot_de_passe'];

                    echo "<p id='message-connexion'>" . "Bienvenue " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . " !" . "<br>" . "<br>" . "Redirection vers la page de votre compte dans 5 secondes..." .  "</p>";

                    echo "<meta HTTP-EQUIV='REFRESH' content='5; url=compte.php'>";

                } else {
                    echo "<p class='message-mot-de-passe-identifiant'>" . "Mauvais identifiant ou mot de passe" . "</p>";
                }
            }
        $request->closeCursor();
        }
    }


    public function userMoficication()
    {
        if (isset($_POST['modifier-compte']))

        {
            echo   "<fieldset id='fieldset-modification'>
                    <h1>Gestionnaire de compte</h1>
                    <br>
                    <br>
                    <br>
                    <form id='gestion-compte' method='POST'>
                    <div>
                    <label class='label-modification' for='new-email'>Nouvelle adresse mail :</label>
                    <input type='mail' class='input-modification' name='new-email' required>
                    <br>
                    <br>
                    <input class='submit-modification' type='submit' value='Modifier email' name='modifier-email'>
                    </div>
                    <br>                    
                    <br>
                    </form>
                    <form id='gestion-compte' method='POST'>
                    <div>
                    <label class='label-modification' for ='new-password1'>Nouveau mot de passe :</label>
                    <input type='password' class='input-modification' name='new-password1' minlength='8' required>
                    <br>
                    <br>
                    <label class='label-modification' for ='new-password2'>Comfirmez nouveau mot de passe :</label>
                    <input type='password' class='input-modification' name='new-password2' minlength='8' required>
                    <br>
                    <br>
                    <input class='submit-modification' type='submit' value='Modifier mot de passe' name='modifier-mot-de-passe'>
                    <br>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div>
                    <input type='button' id='submit-annulation' value='Annuler modification' onclick=window.location.href='compte.php'>
                    </div>
                    </form>  
                    <form method='POST'> 
                    <input type='submit' id='submit-supprimer' value='Supprimer le compte' name='supprimer'>                  
                    </form>                   
                    </fieldset>";
        }                    


        if (isset($_POST['déconnexion'])) {

            echo "<p id='redirection-deconnexion'>" . "Déconnexion : redirection vers la page de connexion dans 3 secondes..." . "</p>";

            echo "<meta HTTP-EQUIV='REFRESH' content='3; url=connexion.php'>";

            session_destroy();
        }

        if (isset($_POST['new-email']) AND isset($_POST['modifier-email'])) {

            $new_email = $_POST['new-email'];
            $email = $_SESSION['email'];
            $prenom = $_SESSION['prenom'];
            $nom = $_SESSION['nom'];

            $request = $this->_db->query("UPDATE membre SET email = '$new_email' WHERE email = '$email'");

            echo "<div class='redirection-modification'>" .
                 "<p>" . "L'adresse mail a bien été modifier pour le compte de " . $prenom . " " . $nom . "</p>" .
                 "<p>" . "Redirection vers la page de connexion dans 5 secondes..." . "</p>" . 
                 "</div>";

            echo "<meta HTTP-EQUIV='REFRESH' content='5; url=connexion.php'>";

            session_destroy(); 
            $request->closeCursor();           
        }

        if (isset($_POST['new-password1']) AND  isset($_POST['new-password2']) AND isset($_POST['modifier-mot-de-passe'])) {
            
            $email = $_SESSION['email'];
            $new_password1 = $_POST['new-password1'];
            $new_password2 = $_POST['new-password2'];
            $prenom = $_SESSION['prenom'];
            $nom = $_SESSION['nom'];

            if ($new_password1 !== $new_password2) {

                echo "<p class='comfirmation-mot-de-passe-modif'>" . "Veuillez comfirmer votre mot de passe !" . "</p>";
                return;
            }
            if ($new_password1 === $new_password2) {
                $pass_hache = password_hash($new_password2, PASSWORD_DEFAULT);

                $request = $this->_db->query("UPDATE membre SET mot_de_passe = '$pass_hache' WHERE email = '$email'");

                echo "<div class='redirection-modification'>" .
                 "<p>" . "Le mot de passe a bien été modifier pour le compte de " . $prenom . " " . $nom . "</p>" .
                 "<p>" . "Redirection vers la page de connexion dans 5 secondes..." . "</p>" . 
                 "</div>";

                echo "<meta HTTP-EQUIV='REFRESH' content='5; url=connexion.php'>";

                session_destroy();
                $request->closeCursor();
            }

        }
        if (isset($_POST['supprimer'])) {
        
            echo   "<fieldset id='fieldset-suppression'>
                    <h1>Suppression de compte</h1>
                    <br>
                    <br>
                    <br>
                    <form method='POST'>
                    <div>
                    <label class='label-modification' for='email'>Adresse mail :</label>
                    <input type='mail' class='input-modification' name='email' required>
                    <br>
                    <br>
                    <div>
                    <label class='label-modification' for ='password1'>Mot de passe :</label>
                    <input type='password' class='input-modification' name='password1' minlength='8' required>
                    <br>
                    <br>
                    <label class='label-modification' for ='password2'>Comfirmez mot de passe :</label>
                    <input type='password' class='input-modification' name='password2' minlength='8' required>
                    <br>
                    <br>
                    <input class='submit-modification' type='submit' value='Supprimer le compte' name='supprimer-compte'>
                    <br>
                    </div>
                    <br>
                    <br>
                    <div>
                    </fieldset>";               
                }
                if (isset($_POST['email']) AND isset($_POST['password1']) AND isset($_POST['password2']) AND isset($_POST['supprimer-compte'])) {

                    $email = $_POST['email'];
                    $password1 = $_POST['password1'];
                    $password2 = $_POST['password2'];
                    $prenom = $_SESSION['prenom'];
                    $nom = $_SESSION['nom'];
                    $mot_de_passe = $_SESSION['mot_de_passe'];
                    if ($password1 !== $password2) {
    
                    echo "<p class='comfirmation-mot-de-passe-modif'>" . "Veuillez comfirmer votre mot de passe !" . "</p>";
                    return;
                    }

                    $isPasswordCorrect = password_verify($password2, $mot_de_passe);
                    if ($password1 === $password2 AND $isPasswordCorrect) {
    
                    $request = $this->_db->query("UPDATE membre SET nom = NUll, prenom = NULL, date_de_naissance = NULL, genre = NULL, ville = NULL, email = NULL, loisirs = NULL, mot_de_passe = NULL, date_inscription = NULL WHERE email = '$email'");
                    
                    echo   "<div class='redirection-modification'>" .
                           "<p>" . "Le compte de " . $prenom . " " . $nom . " a bien été supprimé" . "</p>" .
                           "<p>" . "Redirection vers la page de d'accueil dans 5 secondes..." . "</p>" . 
                           "</div>"; 
                           
                    echo "<meta HTTP-EQUIV='REFRESH' content='5; url=index.php'>";

                    session_destroy();
                    $request->closeCursor();
            }       
        }
    }
}