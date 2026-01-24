# Carte_Interactive_T_L_A




![Motoc](Nvmbro....jpeg)

# Carte interactive
**Mp4 TermD**

Une carte interactive.

**Developed by [Soka7](https://github.com/Soka7), [Yolked64](https://github.com/Yolked64), [tchoupilegoat](https://github.com/tchoupilegoat)**

## ✨Features

## 🚀 Infos

```bash
#Discord pour le projet.
https://discord.gg/pEbEvhgC
```

### Basiques
```bash
# Installer les dependances
pip install -r requirements.txt
```

### Référence README pour une lecture (et une correction) agréable.
```bash
https://github.com/mhucka/readmine/blob/main/README.md?plain=1

```
# Description
Ce projet de terminale NSI (Numérique et Sciences Informatiques) vise à créer une carte interactive où les utilisateurs peuvent signaler et visualiser l'emplacement des caméras de surveillance dans la ville de Nantes. L'objectif est de sensibiliser à la surveillance dans l'espace public et de permettre aux citoyens de savoir où ils sont surveillés.

# Fonctionnalités
Carte interactive : Visualisation des caméras sur une carte Leaflet (les cameras ne s'affichent pas)
Ajout de caméras : Les utilisateurs connectés peuvent ajouter de nouvelles caméras
Système d'authentification : Création de compte et connexion sécurisée
Panel administrateur : Gestion des logs, caméras et utilisateurs
Vérification des caméras : Système de validation par les administrateurs
Galerie de sources : Présentation en 3D des vidéos sources (les videos ne peuvent pas s'afficher)

# Outils/Languages
HTML/CSS - JS - Leaflet - PHP - SQL

# Mettre en place la table
importer dans phpmyadmin la table : carte_interactive.sql
!!! Faire attention à ce que les logins soient : 'root' , 'ChuckNorris44'

# Structure de la base de donnees
Table cameras

id_camera (INT, PK) : Identifiant unique
coordonnees (POINT) : Coordonnées GPS (latitude, longitude)
lien_photo (TEXT) : URL de l'image de la caméra
origin_user (INT, FK) : ID de l'utilisateur créateur
verifie (INT) : Statut de vérification (0/1)
Titre (TEXT) : Titre descriptif de la caméra

Table login

id_user (INT, PK) : Identifiant unique
mdp (TEXT) : Mot de passe hashé (BCRYPT)
email (TEXT) : Adresse email
admin (INT) : Droits administrateur (0/1)

Table log

id_log (INT, PK) : Identifiant unique
temps (TEXT) : Horodatage
type (TEXT) : Type d'action
id_user (INT, FK) : ID utilisateur
id_cam (INT, FK) : ID caméra concernée

# Mettre en place le serveur
copier le git su xubuntu avec la commande
```bash
cd /var/html/www/
sudo git clone https://github.com/Soka7/Carte_Interactive_T_L_A.git
```

# ouvrir le site
-allez dans votre navigateur internet
-tapez 'http://127.0.0.1/Carte_Interactive_T_L_A/index1.html'

# Utilisation de l'ia pour corriger certaines choses, mais reverification systematique


