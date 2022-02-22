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

    <form action="" id="formIndex" method="POST">
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
        <p>veuillez saisir le date de rdv :</p>
        <input type="date" name="date">
        <br>
        <label for="services">veuillez saisir le type de service :</label>
        <select name="service" id="service">
            <option value="pneu">Remplacement des pneus</option>
            <option value="frein">Remplacement disque & plaquettes</option>
            <option value="revision">Réaliser une révision</option>
            <option value="vidange">Réaliser une Vidange</option>
        </select>
        <br>
        <input type="submit" id="btn" value="Ajouter">
    </form>
    <!-- <form action="service.php" method="GET">
        <input type="submit" value="Regarder les prix estimee">
    </form> -->
    <script src="rdv.js"></script>

    <?php

    if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['numero']) && isset($_POST['date'])) {
        $name = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $numero = $_POST['numero'];
        $date = $_POST['date'];
        $service = $_POST['service'];



        $bdd = new PDO(
            'mysql:host=localhost;dbname=garage1',
            'root',
            '',
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );

        // $idRdv = $bdd->query('SELECT id_rdv FROM rendezvous');
        // var_dump($idRdv);

        $bdd->exec("set names utf8");
        //echo "Nom : ".$name."";
        //echo "prenom: ".$prenom."";
        //echo "date: ".$date."";
        //var_dump($bdd);
        try {
            // Insert to service
            $reqService = $bdd->prepare("INSERT INTO services SET type_service = :type_service");
            $resultatService = $reqService->execute(array(':type_service' => $service));
            // recup idSERVICE
            $idService = $bdd->query("SELECT id_service FROM services JOIN obtenir WHERE services.id_service = obtenir.id_service");
            // Insert to RDV
            $reqRdv = $bdd->prepare("INSERT INTO rendezvous SET date_rdv = :dateRdv");
            $resultat = $reqRdv->execute(array(':dateRdv' => $date));
            // recup idRDV
            $idRdv = $bdd->query("SELECT id_rdv FROM rendezvous JOIN clients WHERE clients.id_rdv = rendezvous.id_rdv");
            // Insert to client
            $reqUser = $bdd->prepare("INSERT INTO clients (nom_client, prenom_client, email_client, tel_client, id_rdv) VALUES (:nom, :prenom, :email, :tel, :idRdv)");
            $resultatClient = $reqUser->execute(array(':nom' => $name, ':prenom' => $prenom, ':email' => $email, ':tel' => $numero, ':idRdv' => $idRdv));
            // recup idUSER
            $idUSER = $bdd->query("SELECT id_client FROM clients JOIN obtenir WHERE clients.id_client = obtenir.id_client");
            // Insert FK to obtenir
            $reqObtenir = $bdd->prepare("INSERT INTO obtenir SET id_service = :id_service, id_client = :id_client");
            $resultatObtenir = $reqObtenir->execute(array(':id_service' => $idService, ':id_client' => $idUSER));

            $resultatAll = $resultat + $resultatClient + $resultatObtenir + $resultatService;

            if ($resultatAll) {
                $reqAll = $bdd->prepare('SELECT clients.nom_client, clients.prenom_client, clients.email_client, rendezvous.date_rdv, rendezvous.type_rdv FROM clients INNER JOIN rendezvous ON clients.id_rdv = rendezvous.id_rdv');
                //$req2 = $bdd->query("SELECT clients.nom_client, clients.prenom_client, clients.email_client, rendezvous.date_rdv, rendezvous.type_rdv FROM clients INNER JOIN rendezvous ON clients.id_rdv = rendezvous.id_rdv");
                $reqAll->execute();
                while ($donnees = $reqAll->fetch()) {
                }
            } else {
                echo "<p>Erreur lors de l'enregistrement</p>";
            }
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    ?>
</body>

</html>