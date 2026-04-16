# GestDépense - Gestionnaire de Dépenses

## Description

GestDépense est une application web moderne de gestion des dépenses personnelles. Elle permet aux utilisateurs de suivre leurs dépenses, les catégoriser et analyser leurs habitudes de consommation.

## Fonctionnalités principales

### 1. **Authentification utilisateur**

- Inscription avec validation
- Connexion sécurisée avec hash de mot de passe
- Déconnexion
- Session management

### 2. **Tableau de Bord**

- Total des dépenses mensuelles
- Dépense la plus élevée du mois
- Répartition des dépenses par catégorie avec graphique
- Vue d'ensemble statistique

### 3. **Gestion des Dépenses (CRUD)**

- Ajouter une nouvelle dépense
- Visualiser toutes les dépenses
- Modifier une dépense existante
- Supprimer une dépense
- Filtrage par catégorie et par mois

### 4. **Catégories**

- Catégorisation automatique des dépenses
- Analyse par catégorie

## Installation

### Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Apache/WAMP64

### Étapes d'installation

1. **Cloner ou télécharger le projet**

   ```bash
   cd c:\wamp64\www\gest_depes
   ```

2. **Créer la base de données**

   ```sql
   CREATE DATABASE gestion_depenses;
   ```

3. **Créer les tables**

   ```sql
   USE gestion_depenses;

   -- Table des utilisateurs
   CREATE TABLE users (
       id INT PRIMARY KEY AUTO_INCREMENT,
       nom VARCHAR(100) NOT NULL,
       email VARCHAR(100) UNIQUE NOT NULL,
       mot_de_passe VARCHAR(255) NOT NULL,
       date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   -- Table des catégories
   CREATE TABLE categories (
       id INT PRIMARY KEY AUTO_INCREMENT,
       nom VARCHAR(50) NOT NULL UNIQUE
   );

   -- Table des dépenses
   CREATE TABLE depenses (
       id INT PRIMARY KEY AUTO_INCREMENT,
       user_id INT NOT NULL,
       montant DECIMAL(10, 2) NOT NULL,
       description TEXT,
       categorie_id INT NOT NULL,
       date_depense DATE NOT NULL,
       date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
       FOREIGN KEY (categorie_id) REFERENCES categories(id)
   );

   -- Insérer les catégories par défaut
   INSERT INTO categories (nom) VALUES
   ('Alimentation'),
   ('Transport'),
   ('Logement'),
   ('Loisirs'),
   ('Santé'),
   ('Éducation'),
   ('Autres');
   ```

4. **Configurer la base de données**
   Vérifier le fichier `config.php`:

   ```php
   $dsn = 'mysql:host=localhost;dbname=gestion_depenses;charset=utf8';
   $user = 'root';
   $password = '';
   ```

5. **Accéder à l'application**
   - Ouvrir `http://localhost/gest_depes/index.html` dans votre navigateur
   - Créer un compte
   - Se connecter et commencer à gérer vos dépenses

## Structure du projet

```
gest_depes/
├── index.html              # Page d'accueil
├── connexion.php           # Page de connexion
├── inscription.php         # Page d'inscription
├── dashbordd.php           # Tableau de bord
├── crud_depense.php        # Liste des dépenses
├── ajouter.php             # Ajouter une dépense
├── modifier.php            # Modifier une dépense
├── supprimer.php           # Supprimer une dépense
├── logout.php              # Déconnexion
├── config.php              # Configuration BD
├── styles.css              # Styles CSS
├── script.js               # Scripts JavaScript
└── README.md               # Ce fichier
```

## Utilisation

### Première visite

1. Cliquez sur "S'inscrire"
2. Remplissez le formulaire avec vos informations
3. Cliquez sur "S'inscrire"

### Connexion

1. Rendez-vous sur la page d'accueil
2. Cliquez sur "Connexion"
3. Entrez vos identifiants

### Ajouter une dépense

1. Cliquez sur "Ajouter Dépense"
2. Remplissez le montant, la description, choisissez une catégorie et la date
3. Cliquez sur "Enregistrer la Dépense"

### Voir toutes vos dépenses

1. Cliquez sur "Mes Dépenses"
2. Utilisez les filtres (catégorie, mois) si nécessaire
3. Cliquez sur "Modifier" ou "Supprimer" pour gérer une dépense

### Tableau de Bord

1. Cliquez sur "Tableau de Bord"
2. Visualisez vos statistiques et répartition par catégorie

## API Endpoints

### Authentification

- `connexion.php` - POST: Connexion utilisateur
- `inscription.php` - POST: Créer un nouveau compte
- `logout.php` - GET: Déconnexion

### Dépenses

- `crud_depense.php` - GET: Lister les dépenses (avec filtres)
- `ajouter.php` - POST: Créer une nouvelle dépense
- `modifier.php` - POST: Mettre à jour une dépense
- `supprimer.php` - GET: Supprimer une dépense

## Sécurité

- ✅ Authentification par session
- ✅ Hash des mots de passe (PASSWORD_DEFAULT)
- ✅ Prévention des injections SQL (Prepared Statements)
- ✅ Validation des données utilisateur (htmlspecialchars)
- ✅ Contrôle d'accès (vérification de session)

## Technologies utilisées

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.4+
- **Base de données**: MySQL
- **Graphiques**: Chart.js
- **Design**: Responsive Design

## Auteur

Développé en 2026

## Licence

Libre d'utilisation

## Support

Pour toute question ou problème, veuillez consulter la documentation ou créer une issue.
