
// MISE EN PLACE DE LA CARTE

// Initialisation de la carte   (centrée sur le cxhâteau des Ducs - niv de zoom 16)
let map = L.map('map').setView([47.2160, -1.5493], 16);

// Gestion du fond de carte openstreetmap
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

// insertion du marqueur pour le Miroir d'eau
let marker = L.marker([47.2150, -1.5491], {title: "More info",});
    // ajout à la carte
marker.addTo(map).bindPopup("<div class = pop><div class = 'pop_text'><h1>Miroir d'eau</h1><p>Le miroir d'eau de Nantes est une pièce d'eau peu profonde située dans le centre-ville de Nantes.</p><br><video controls autoplay><source src='Nantes.mp4'></source></video><br><p>The video may occur to be unavailable. it is NOT a code error and may be occured by bad video quality or bad engine. We take NO reponsability about that.</p></div>");
    // bulle avec texte
marker.bindTooltip("Miroir d'eau", {
   direction: "top",
   permanent: true,
   offset: [-15,-15], // on décale un peu la bulle vers le haut et à gauche,
   opacity: 0.6 // semi transparente
}).openTooltip();

function onMapClick(e) {
    let marker = L.marker(e.latlng, {title: "More info",});
        // ajout à la carte
    marker.addTo(map);
        // bulle avec texte
    marker.bindTooltip(e.latlng.toString(), {
    direction: "top",
    permanent: true,
    offset: [-15,-15], // on décale un peu la bulle vers le haut et à gauche,
    opacity: 0.6 // semi transparente
    }).openTooltip();

    var circle = L.circle(e.latlng, {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 10
    }).addTo(map);
}

//...

map.on('click', onMapClick);

const map_ = document.getElementById("map")
const btn = document.querySelector(".Expand")

btn.addEventListener("click", () => {
    map_.classList.toggle("expand")
    map.invalidateSize()
    btn.classList.toggle("ex")
})

//ChatGPT utilise pour mieux comprendre la source des erreurs.