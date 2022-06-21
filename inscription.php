<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();

//connection a la base de donnee 
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8', 'root', ''); //connection a la BDD
//condition SI le boutton envoie n'est pas vide 
if (isset($_POST['envoi'])) {
    //condition SI pseudo et mdp son vide
    if (!empty($_POST['pseudo']) and !empty($_POST['mdp'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']); //Sécurise le champ pseudo.
        //$mdp = sha1($_POST['mdp']);//Sécurise le champ mdp.
        $mdp = $_POST['mdp'];

        $insertUser = $bdd->prepare('INSERT INTO users(pseudo,mdp) VALUES(?,?)'); // Requête pour insérer dans BDD
        $insertUser->execute([$pseudo, $mdp]);//execute la requete

        $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ?'); //Requête pour récupère l'id
        $recupUser->execute([$pseudo, $mdp]);//Exécute la requête.

        if ($recupUser->rowCount() > 0) {

            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['id'] = $recupUser->fetch()['id'];//Récupère l'ID via la requête $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ?');
            header('Location: connexion.php');// Redirige vers la page de connexion.
        }


    } elseif (empty($_POST['mdp'])) {
        echo 'veuillez remplir le champ mdp';
    } elseif (empty($_POST['pseudo'])) {
        echo 'veuillez remplir le champ pseudo';
    } elseif (empty($_POST['pseudo']) and empty($_POST['mdp'])) {
        echo 'veuillez remplir les champs...';
    }

}
?>

    <!doctype html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>inscription</title>
    </head>

    <body>
    <h1>espace iscription</h1>
    <form method="POST" action="" align=" center">

        <input type="text" name="pseudo" placeholder="pseudo" autocomplete="off">
        <br><br>
        <input type="password" name="mdp" placeholder="mot de passe" autocomplete="off">
        <br><br>
        <input type="submit" name="envoi">

    </form>
    </body>

    </html>

<?php
