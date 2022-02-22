<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="contact.css">
    <title>4_tyres</title>
</head>
<body>

<h1>DEVIS GRATUIT ET RENDEZ-VOUS IMMEDIAT</h1>
    <form action="" method="POST"> 
        <p>veuillez saisir votre nom:</p>
        <input type="text" name="nom">
        <br>
        <p>veuillez saisir votre prenom :</p>
        <input type="text" name="prenom">
        <br>
        <p>veuillez saisir votre Email :</p>
        <input type="text" name="email">
        <br>
        <p>veuillez saisir votre numero :</p>
        <input type="text" name="numero">
        <br>
        <p>veuillez saisir votre demande :</p>
        <textarea name="contenu" id="contenu" cols="30" rows="10"></textarea>
        <br>
        <input type="submit" id="btn" value="Ajouter">
    </form>
    <script src="testContact.js"></script>
<?php

        if (isset($_POST['nom'])&& isset($_POST['prenom']) && isset($_POST['email'])&& isset($_POST['contenu'])&& isset($_POST['numero'])) {
            $name = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $numero = $_POST['numero'];
            $message = $_POST['contenu'];

            $bdd=new PDO('mysql:host=localhost;dbname=garage', 'root','', 
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            $bdd->exec("set names utf8");
            //echo "Nom : ".$name."";
            //echo "prenom: ".$prenom."";
            //var_dump($bdd);
            try {
                $req = $bdd->prepare("INSERT INTO clients SET nom_client = :nom, prenom_client = :prenom, email_client = :email, tel_client = :numero");
                $resultat = $req->execute(array(':nom' => $name, ':prenom' => $prenom, ':email' =>$email, ':numero'=>$numero));

                $req2 = $bdd->prepare("INSERT INTO rendezvous SET message_rdv = :message_rdv");
                $resultat2 = $req2->execute(array(':message_rdv' => $message));


                $resultatAll = $resultat + $resultat2;

                if ($resultatAll){
                    $req1 = $bdd->prepare('SELECT clients.nom_client, clients.prenom_client, clients.email_client, clients.tel_client, rendezvous.message_rdv FROM clients INNER JOIN rendezvous ON clients.id_rdv = rendezvous.id_rdv');
                    $req1->execute();
                    
                    while($donnees = $req1->fetch()){
                        //affichage des donnes
                        //echo '<br>'.$donnees['id_client'].'</br><p><br><h2>'.$donnees['nom_client'].'</br> '.$donnees['email_client'].'</h2></p>';
                    } 
                } else {
                    echo "<p>Erreur lors de l'enregistrement</p>";
                }
            } catch(Exception $e) {
                die('Erreur : ' .$e->getMessage());
            }
        }
        ?>
</body>
</html>