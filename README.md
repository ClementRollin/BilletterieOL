
# Billetterie Olympique Lyonnais

Ce projet est une application de billetterie pour les matchs de l'Olympique Lyonnais. Il permet aux utilisateurs de consulter les matchs à venir, de réserver des places, et de générer un billet en format PDF après réservation.

---

## Fonctionnalités

- **Affichage des matchs** :
  - Liste tous les matchs à domicile de l'OL.
  - Affiche les logos des deux équipes (domicile et extérieur).
  - Indique la date, le nom du match, et le nombre de places restantes.

- **Réservation de places** :
  - Formulaire de réservation demandant le nom, le prénom, l'email, et le nombre de places.
  - Vérification en temps réel du nombre de places disponibles.

- **Génération de PDF** :
  - Génération d'un billet PDF personnalisé contenant :
    - Les détails du match.
    - Le nom du réservataire.
    - Le nombre de places.
    - Les logos des deux équipes.

- **Système de base de données** :
  - Gestion des clubs, des matchs, et des réservations via MySQL.

---

## Technologies utilisées

- **Backend** : PHP natif avec architecture MVC.
- **Frontend** : HTML5, CSS3, Bootstrap 5 pour un design réactif et moderne.
- **Base de données** : MySQL.
- **Génération de PDF** : DomPDF.

---

## Installation

### Prérequis

- PHP ≥ 8.0
- Serveur Web (Apache ou Nginx)
- MySQL ≥ 5.7
- [Composer](https://getcomposer.org/)

### Étapes d'installation

1. Clonez ce dépôt :

   ```bash
   git clone https://github.com/votre-utilisateur/billetterie-ol.git
   cd billetterie-ol
   ```

2. Installez les dépendances PHP via Composer :

   ```bash
   composer install
   ```

3. Configurez votre base de données dans le fichier `model.php` :

   ```php
   $host = 'localhost';
   $dbname = 'ol_tickets';
   $username = 'root';
   $password = '';
   ```

4. Importez le fichier SQL pour créer la structure et les données de la base :

   ```bash
   mysql -u root -p ol_tickets < database.sql
   ```

5. Configurez votre serveur Web pour pointer vers `index.php` comme point d'entrée.

6. Accédez à l'application dans votre navigateur à l'adresse suivante :

   ```
   http://localhost/billetterie-ol
   ```

---

## Structure du projet

```plaintext
.
├── index.php            # Front controller
├── model.php            # Modèle : gestion des accès à la base de données
├── controllers.php      # Contrôleur : logique des actions
├── utils/
│   └── pdf_generator.php # Génération des PDF avec DomPDF
├── templates/
│   ├── layout.php       # Template principal
│   ├── home.php         # Page d'accueil listant les matchs
│   └── booking.php      # Formulaire de réservation
├── public/
│   └── images/          # Logos des clubs (si utilisés en local)
└── database.sql         # Script SQL pour créer la base de données
```

---

## Base de données

### Table `clubs`
Contient les informations des clubs (domicile et extérieur).

| Colonne      | Type         | Description              |
|--------------|--------------|--------------------------|
| `id`         | INT          | Identifiant unique       |
| `name`       | VARCHAR(255) | Nom du club              |
| `logo_url`   | VARCHAR(255) | URL du logo du club      |

### Table `matches`
Gère les matchs à domicile de l'OL.

| Colonne           | Type         | Description                    |
|-------------------|--------------|--------------------------------|
| `id`              | INT          | Identifiant unique du match    |
| `name`            | VARCHAR(255) | Nom du match (OL vs XYZ)       |
| `match_date`      | DATETIME     | Date et heure du match         |
| `home_team_id`    | INT          | Référence vers `clubs` (domicile) |
| `away_team_id`    | INT          | Référence vers `clubs` (extérieur) |
| `total_seats`     | INT          | Nombre total de places         |
| `remaining_seats` | INT          | Nombre de places restantes     |

### Table `reservations`
Gère les réservations des utilisateurs.

| Colonne           | Type         | Description                   |
|-------------------|--------------|-------------------------------|
| `id`              | INT          | Identifiant unique de la réservation |
| `match_id`        | INT          | Référence vers `matches`      |
| `customer_name`   | VARCHAR(255) | Nom du client                 |
| `customer_surname`| VARCHAR(255) | Prénom du client              |
| `customer_email`  | VARCHAR(255) | Email du client               |
| `seats`           | INT          | Nombre de places réservées    |

---

## Fonctionnement

1. **Page d'accueil** :
   - Affiche la liste des matchs avec les détails et un bouton "Réserver".

2. **Page de réservation** :
   - Formulaire pour remplir les informations personnelles et le nombre de places souhaitées.
   - Validation en temps réel du nombre de places disponibles.

3. **Confirmation et génération de PDF** :
   - Après réservation, un billet au format PDF est généré avec tous les détails.

---

## Améliorations possibles

- Ajouter un QR code sur le billet pour la validation à l’entrée du stade.
- Intégrer un système de gestion des matchs et des clubs pour les administrateurs.
- Ajouter une file d'attente en cas de forte demande.

---

## Auteurs

- **Nom du développeur** : Clément Rollin
- **École** : MY DIGITAL SCHOOL
- **Formation** : Master Développeur Full Stack
- **Année** : 2024-2025
- **Cours** : Architecture Logicielle
- **Lieu** : Lyon
