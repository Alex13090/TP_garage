const titre = document.body.getElementsByTagName("h1");
const txt = document.body.getElementsByTagName("p");

const lien = document.body.getElementsByTagName("a")[0];


lien.setAttribute("href", "FilR.html");
console.log(lien.getAttribute("href"));


function ajoutCreateur(name, role) {
    const newTxt = document.createElement("p");

    newTxt.innerHTML = `${name} est ${role}`;
    document.body.appendChild(newTxt);
}
ajoutCreateur("Jessica ", "fondateur");
ajoutCreateur("Anais ", "fondateur");
ajoutCreateur("Tessa ", "fondateur");

var ps = document.querySelectorAll('p')
for (var i=0; i<ps.length; i++) {
   (function(p) {
    window.setInterval(function () {
        p.classList.toggle('indianred')
    }, 1000)
   }) (ps[i])
}