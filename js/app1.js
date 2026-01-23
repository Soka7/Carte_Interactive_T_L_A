// MISE EN PLACE DE LA CARTE

// Initialisation de la carte   (centrée sur le château des Ducs - niv de zoom 16)
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

var DeuxPins = []

// UPDATED CAMERA CLICK HANDLER WITH DEBUGGING code de départ a la main modifie par claude
function onMapClick(e) {
    console.log("Map clicked at:", e.latlng);
    
    let marker = L.marker(e.latlng, {title: "More info"});

    // Add to map with popup
    marker.addTo(map).bindPopup("<div class='pop'><div class='pop_text'><h1>Camera</h1><p>Ajouter une caméra ?</p><br><form id='FOOORM' type='post' ACTION='FormCam.php'><input placeholder='Titre' type='text' name='cam' required><br><input placeholder='Lien photo (Url)' type='text' name='lien_photo' required><input id='FormBtn' type='submit'></form></div></div>");
    
    // Tooltip
    marker.bindTooltip(e.latlng.toString(), {
        direction: "top",
        permanent: true,
        offset: [-15,-15],
        opacity: 0.6
    }).openTooltip();

    // Store coordinates
    var lati = e.latlng.lat;
    var long = e.latlng.lng;
    
    console.log("Stored coordinates - Lat:", lati, "Long:", long);

    // Handle popup open
    marker.on("popupopen", () => {
        console.log("Popup opened");
        
        const frm = document.getElementById('FOOORM');
        
        if (!frm) {
            console.error("Form not found!");
            return;
        }

        frm.addEventListener('submit', (e) => {
            e.preventDefault();
            console.log("Form submitted");

            const fData = new FormData(frm);

            const data = {
                cam: fData.get("cam"),
                lien_photo: fData.get("lien_photo"),
                latitude: lati,
                longitude: long
            };

            console.log("Data to send:", data);
            console.log("JSON string:", JSON.stringify(data));

            fetch('FormCam.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                console.log("Response status:", response.status);
                console.log("Response headers:", response.headers);
                return response.text(); // Get text first to see what we get
            })
            .then(text => {
                console.log("Response text:", text);
                
                // Check if it's a redirect or HTML
                if (text.includes('<') || text.includes('html')) {
                    console.warn("Received HTML instead of expected response");
                    alert("Received HTML response. Check if you're logged in.");
                } else if (text.includes('SUCCESS')) {
                    alert("Caméra ajoutée avec succès!");
                    window.location.reload();
                } else if (text.includes('ERROR')) {
                    alert("Erreur: " + text);
                } else {
                    alert("Réponse inattendue: " + text);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Erreur de connexion: ' + error.message);
            });
        });

        const BoutonForm = document.getElementById("FormBtn");
        if (BoutonForm) {
            BoutonForm.addEventListener("click", () => {
                console.log("Submit button clicked");
            });
        }
    });

    // Circle and polyline code...
    var circle = L.circle(e.latlng, {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 10
    }).addTo(map);

    DeuxPins.push([lati, long]);

    for (let i = 0; i < DeuxPins.length; i++){
        for (let n = i + 1; n < DeuxPins.length; n++){
            let p1 = L.latLng(DeuxPins[i]);
            let p2 = L.latLng(DeuxPins[n]);
            let di = p1.distanceTo(p2);
            var line = L.polyline([DeuxPins[i], DeuxPins[n]], {
                color: "red",
                weight: 3,
                dashArray: "10, 10"
            }).addTo(map);

            line.bindTooltip(di.toFixed(2), {
                permanent: false,
                direction: "center"
            }).openTooltip();
        }
    }
}

////////////////////////////////

map.on('click', onMapClick);

const map_ = document.getElementById("map")
const btn = document.querySelector(".Expand")

btn.addEventListener("click", () => {
    map_.classList.toggle("expand")
    map.invalidateSize()
    btn.classList.toggle("ex")
})


//ChatGPT utilise pour mieux comprendre la source des erreurs.