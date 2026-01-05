
// MISE EN PLACE DE LA CARTE

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