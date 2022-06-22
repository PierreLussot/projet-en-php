<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8', 'root', '');

if (isset($_POST['envoi'])) {


    if (!empty($_POST['pseudo']) and !empty($_POST['mdp'])) {

        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = $_POST['mdp'];

        $recupUser = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ? ');
        $recupUser->execute([$pseudo, $mdp]);

        if ($recupUser->rowCount() > 0) {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['id'] = $recupUser->fetch()['id'];
header('Location: index.php');
        } else {
            echo 'votre mot de passe ou pseudo est incorrect...';
        }

    } else {
        echo 'veuillez remplir tous les champs';
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
    <title>connection</title>
</head>

<body>
<h1>espace connexion</h1>
<form method="POST" action="" align=" center">

    <input type="text" name="pseudo" placeholder="pseudo" autocomplete="off">
    <br><br>
    <input type="password" name="mdp" placeholder="mot de passe" autocomplete="off">
    <br><br>
    <input type="submit" name="envoi">

</form>
</body>

</html>