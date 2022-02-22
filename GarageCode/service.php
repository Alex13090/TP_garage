<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="contact.css">
    <title>4_tyres</title>
</head>
<body>
    <h1>Le prix estimee :</h1>

<?php

    if (isset($_GET)) {
        $bdd = new PDO('mysql:host=localhost;dbname=garage', 'root','', 
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        $bdd->exec("set names utf8");
        try {
            $req = $bdd->prepare('SELECT services.type_service, services.prix_service, rendezvous.date_rdv FROM obtenir INNER JOIN clients ON clients.id_client = obtenir.id_client INNER JOIN rendezvous ON clients.id_rdv = rendezvous.id_rdv INNER JOIN services ON obtenir.id_service = services.id_service');
            $req->execute();
            var_dump($donnees=$req->fetch());
            while($donnees = $req->fetch()){
                extract($donnees);
                echo'<p>'.$donnees['type_service'].'<br>'.$donnees['prix_service'].'<br>le technicien vas occuper à votre voiture '.$donnees['date_rdv'].'</p>';
                } 
            } catch(Exception $e) {
                die('Erreur : ' .$e->getMessage());
        }
    }
?>
</body>
</html>


