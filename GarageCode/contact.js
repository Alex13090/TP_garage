document.getElementById("conteiner").addEventListener("submit", function (e) {
    //e.preventDefault();

    var erreur;

    var inputs = documents.getElementByTagName("input");
    console.log(inputs);
    for(var i=0; i< inputs.length; i++) {
        if (!inputs[i].value) {
            erreur = "Veuillez completez";
        }
    }

    if (erreur) {
        e.preventDefault();
        document.getElementById("erreur").innerHTML = erreur;
        return false;
    } else {
        alert('Formulaire envoye!');
    }

    document.getElementById("btn").addEventListener("click", function() {
        alert("Nous avons bien reçu votre demande, un technicien va répondre dans les plus bref délais ");
    });
    // const form = document.getElementById("conteiner");
    // const userName = document.getElementById("ContactName");
    // const mail = document.getElementById("ContactMail");
    // const tel = document.getElementById("ContactNumber");
    // const message = document.getElementById("msg");

    // if (!form.value) {
    //     erreur = "Veuillez renseigner votre form";
    // }
    // if (!userName.value) {
    //     erreur = "Veuillez renseigner votre Nom";
    // }
    // if (!mail.value) {
    //     erreur = "Veuillez renseigner votre Email";
    // }
    // if (!tel.value) {
    //     erreur = "Veuillez renseigner votre numéro de téléphone"; 
    // }
    // if (!message.value) {
    //     erreur = "Veuillez renseigner votre message";
    // }

});