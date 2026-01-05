
// ACCES A LA BASE + ECRITURE JSON

// Initialisation de la carte   (centrée sur le cxhâteau des Ducs - niv de zoom 16)
let map = L.map('map').setView([47.2160, -1.5493], 16);

// Gestion du fond de carte openstreetmap
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

// insertion du marqueur pour le Miroir d'eau
let marker = L.marker([47.2150, -1.5491]);
    // ajout à la carte
marker.addTo(map);
    // bulle avec texte
marker.bindTooltip("Miroir d'eau", {
   direction: "top",
   permanent: true,
   offset: [-15,-15], // on décale un peu la bulle vers le haut et à gauche,
   opacity: 0.6 // semi transparente
}).openTooltip();


// RECUPERATION DES VALEURS JSON

// forEach (JS)  équivalent à   for prod in produits (PYTHON)   ou    foreach($produits as $prod)  (PHP)
produits.forEach(
    function (prod){

        // écriture du nom dans une balise p
        let new_p = document.createElement("p");            // création de la balise
        let texte = document.createTextNode(prod["nom"]);   // création du texte
        new_p.appendChild(texte);                           // insertion du texte dans la balise p

        // ajout de la balise p dans la balise div #affichage
        document.getElementById("affichage").appendChild(new_p);

        // ajout d'une classe éventuellement
        //new_p.classList.add("classe_de_p"); 
    }
);
