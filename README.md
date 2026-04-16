# 💰 fintrack - Gestionnaire de Dépenses

## 📖 À propos

**fintrack** est une application web moderne de gestion des dépenses personnelles. Elle permet aux utilisateurs de:
- 📊 Suivre leurs dépenses en temps réel
- 📈 Analyser leurs habitudes de consommation
- ⚠️ Recevoir des alertes budgétaires
- 🎯 Atteindre leurs objectifs financiers

**Tech Stack**: PHP 7.4+ | MySQL/PostgreSQL | HTML5/CSS3 | JavaScript | Render Cloud

---

## ✨ Fonctionnalités

### 🔐 Authentification
- ✅ Inscription avec validation (email unique, password fort)
- ✅ Login sécurisé (password hashé)
- ✅ Session management
- ✅ Isolation utilisateur

### 📊 Tableau de Bord
- ✅ Statistiques mensuelles (total, max dépense)
- ✅ Graphique pie (répartition par catégorie)
- ✅ Budget remaining (% utilisé)
- ✅ Alerte budget (80% orange, 100%+ rouge)
- ✅ Revenue mensuel configurable

### 💸 Gestion des Dépenses (CRUD)
- ✅ Ajouter dépense (montant, description, catégorie, date)
- ✅ Lister avec filtres (catégorie, mois)
- ✅ Modifier dépense
- ✅ Supprimer dépense
- ✅ Export données

### 📂 7 Catégories
- 🍔 Alimentation
- 🚗 Transport
- 🏠 Logement
- 🎮 Loisirs
- 🏥 Santé
- 📚 Éducation
- 📌 Autres

---

## 🚀 Déploiement sur Render

### 📋 Guides disponibles:
- **[RENDER_DEPLOYMENT_CHECKLIST.md](RENDER_DEPLOYMENT_CHECKLIST.md)** ← START HERE! 📍
- [POSTGRES_SETUP.md](POSTGRES_SETUP.md) - Configuration PostgreSQL
- [FAQ_RENDER.md](FAQ_RENDER.md) - 20 questions fréquentes

### Quickstart (6 étapes):
1. Créer PostgreSQL sur Render
2. Créer Web Service Render
3. Ajouter variables d'environnement
4. Déployer
5. Initialiser BD via `/install_postgres.php`
6. Accéder à `https://fintrack-xxxx.onrender.com`

**Temps: ~10 minutes**

---

## 💻 Installation Locale

### Prérequis
- PHP 7.4+
- MySQL 5.7+ OU PostgreSQL 12+
- Apache/WAMP64 OU `php -S`

### Étapes
1. Clone le repo:
   ```bash
   git clone https://github.com/christdaviddjek-ai/fintrack.git
   cd fintrack
   ```

2. Accès local:
   ```bash
   php -S localhost:8000
   ```

3. Ouvre: `http://localhost:8000/index.html`

4. Initialise la BD:
   - MySQL: `/install.php`
   - PostgreSQL: `/install_postgres.php`

---

## 🏗️ Architecture

```
fintrack/
├── index.html           # Landing page
├── inscription.php      # Signup
├── connexion.php        # Login
├── dashbordd.php        # Dashboard
├── crud_depense.php     # List expenses
├── ajouter.php         # Add expense
├── modifier.php        # Edit expense
├── supprimer.php       # Delete expense
├── config.php          # DB config (MySQL/PostgreSQL)
├── config_advanced.php # Advanced settings
├── install.php         # MySQL initialization
├── install_postgres.php # PostgreSQL initialization
├── health.php          # Health check endpoint
├── styles.css          # 1000+ lines responsive design
├── script.js           # Validation + interactions
└── render.yaml         # Render deployment config
```

---

## 🗄️ Base de données

### Tables:
- **users** (id, nom, email, mot_de_passe, revenu_mensuel, date_creation)
- **categories** (id, nom, icon, couleur)
- **depenses** (id, user_id, montant, description, categorie_id, date_depense)

### Support:
- ✅ MySQL 5.7+
- ✅ PostgreSQL 12+
- Auto-détection via `DB_TYPE` variable

---

## 🔐 Sécurité

- ✅ Password hashing (PASSWORD_DEFAULT)
- ✅ SQL injection prevention (prepared statements)
- ✅ XSS prevention (htmlspecialchars)
- ✅ Session-based auth
- ✅ User data isolation

---

## 📱 Responsive Design

- ✅ Mobile first (<480px)
- ✅ Tablet ready (480px-768px)
- ✅ Desktop optimized (>768px)
- ✅ Hamburger menu
- ✅ Touch-friendly

---

## 🚀 Mise à jour continue

1. Modifie le code localement
2. `git push`
3. Render redéploie **automatiquement**
4. 0 downtime!

---

## 📞 Support

- 📖 [RENDER_DEPLOYMENT_CHECKLIST.md](RENDER_DEPLOYMENT_CHECKLIST.md)
- ❓ [FAQ_RENDER.md](FAQ_RENDER.md)
- 🐛 Issues: GitHub Issues

---

## 📊 Statistiques du Projet

- **Fichiers PHP**: 9
- **Fichiers Frontend**: 2 (HTML/CSS)
- **Lignes CSS**: 1000+
- **Requêtes SQL**: 30+
- **Fonctionnalités**: 20+
- **Temps de réaction**: <200ms

---

## 📝 Licence

© 2026 fintrack. MIT License.

---

## 🎯 Version Actuelle

- **v2.0** - PostgreSQL support + Render ready
- Auto-deployment via GitHub webhooks
- Multi-environment support (Local/PostgreSQL/MySQL)

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
