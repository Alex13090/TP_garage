<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>4_tyres_Contact</title>
    <link rel="stylesheet" href="contact.css">
</head>

<body>
    <header>
        <h1>Contact</h1>


        <article>
            <h3>DEVIS GRATUIT ET RENDEZ-VOUS IMMÉDIAT</h3>
            <h2>Recherchez ici votre prestation : freinage, vidange, distribution...</h2>
            <div>
                <p>Envoyez nous rapidement vos questions ou demandes depuis ce formulaire. Nous vous répondrons dans les
                    plus brefs délais.</p>
            </div>
        </article>
    </header>
    <section>
        <form method="POST" action="" id="conteiner">
            <div class="page">
                <label for="name">Nom</label>
                <input type="text" name="nom" value="Votre Nom" size="20" placeholder="nom" maxlength="20"
                    id="ContactName" required />
            </div>
            <div class="page">
                <label for="email">E-mail</E-mail></label>
                <input type="email" name="email" value="Votre adresse E-mail" size="20" placeholder="E-mail"
                    maxlength="20" id="ContactMail" required />
            </div>
            <div class="page">
                <label for="Numero">Numero</label>
                <input type="text" name="numero" value="N° de téléphone" size="25" placeholder="Numero" maxlength="20"
                    id="ContactNumber" />
            </div>
            <div class="page">
                <label for="message">VOTRE PRESTATION:</label>
                <textarea placeholder="votre message" name="message" cols="50" rows="20" id="msg"></textarea>
            </div class="page">
            <div><button> Envoyer </button> <input type="reset" nom="envoyer" id="btn" value="Annuler"></input></div>
        </form>
    </section>
    <footer>
        <ul>
            <li><a href="accueil.html">Accueil</a></li>
            <li><a href="#">Mentions légales</a></li>
            <li><a href="#">Politique de Confidentalité</a></li>
        </ul>
    </footer>
</body>

</html>
<?php


if (isset($_POST['nom'])&& 
isset($_POST['email'])&&
isset($_POST['numero'])) {
    $name = $_POST['nom'];
    $email = $_POST['email'];
    $numero = $_POST['numero'];

    $bdd=new PDO('mysql:host=localhost;dbname=garage1', 'root','', 
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $bdd->exec("set names utf8");
    var_dump($bdd);
    try {
        $req = $bdd->prepare(
            "INSERT INTO 
                clients
            SET 
            nom_client = :name,
            email_client = :email,
            tel_client = :numero "

        );
        $resultat = $req->execute(
            array(
                ':nom_client' => $name,
                ':email_client' => $email,
                ':tel_client' => $numero
            )
        );
        if ($resultat){
            $req2 = $bdd->prepare(
                'SELECT
                    *
                FROM 
                    clients 
                /*WHERE 
                nom_client = :name*/'
            );
            $req2->execute(
                array(
                    'nom_client' => $name
                )
            );
            while($donnees = $req2->fetch()){
                echo '<p>Vous venez de créer : 
                '.$donnees['nom_client'].'
                '.$donnees['email_client'].'
                '.$donnees['tel_client'].'
                </p>';
            }
        } else {
            echo "<p>Erreur lors de l'enregistrement</p>";
        }

        $getUserId = $bdd->prepare('SELECT * FROM clients WHERE nom_client = :nom_client');
        $getUserId->execute(array(':nom_client' => $name));
        $userId;

        while($oneUser = $getUserId->fetch()){
            $userId = $oneUser['id_clients'];
        }
        $reqAll = $bdd->prepare('SELECT * FROM clients');
        $reqAll->execute();

        while($allUsers = $reqAll->fetch()){
            if($allUsers['id_client'] != $userId) {
                echo '<p>
                '.$allUsers['nom_client'].'
                '.$allUsers['email_client'].'
                '.$allUsers['tel_client'].'
                </p>';
            }
        }
    } catch(Exception $e) {
        die('Erreur : ' .$e->getMessage());
    }
}
?>
