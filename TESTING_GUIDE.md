# Guide de Démarrage - GestDépense

## 🚀 Démarrage Rapide

### 1. Installation de la Base de Données

Accédez à: `http://localhost/gest_depes/install.php`

Ce script créera automatiquement:

- La base de données `gestion_depenses`
- Les tables: `users`, `categories`, `depenses`
- 7 catégories pré-configurées

### 2. Accéder à l'Application

Rendez-vous sur: `http://localhost/gest_depes/index.html`

## 📋 Flux d'Utilisation

### Phase 1: Authentification

```
index.html → S'inscrire → inscription.php
                ↓
           Remplir le formulaire
                ↓
           Se connecter → connexion.php
                ↓
           Remplir les identifiants
                ↓
           dashbordd.php (Tableau de Bord)
```

### Phase 2: Gestion des Dépenses

```
Tableau de Bord
        ↓
    ┌───┴───┬─────────────┐
    ↓       ↓             ↓
Ajouter  Voir Toutes  Modifier/Supprimer
(ajouter.php) (crud_depense.php) (modifier.php/supprimer.php)
```

## 🔍 Scénarios de Test

### Test 1: Inscription

**Étapes:**

1. Aller sur `http://localhost/gest_depes/index.html`
2. Cliquer sur "Créer un compte"
3. Remplir:
   - Nom: "Jean Dupont"
   - Email: "jean@exemple.com"
   - Mot de passe: "password123"
   - Confirmation: "password123"
4. Cliquer sur "S'inscrire"

**Résultat attendu:** Message de succès et redirection vers connexion

### Test 2: Connexion

**Étapes:**

1. Se connecter avec les identifiants créés
2. Entrer l'email et le mot de passe

**Résultat attendu:** Redirection vers le tableau de bord

### Test 3: Ajouter une Dépense

**Étapes:**

1. Sur le tableau de bord, cliquer sur "Ajouter Dépense"
2. Remplir:
   - Montant: "50.00"
   - Description: "Courses à Carrefour"
   - Catégorie: "Alimentation"
   - Date: Date du jour
3. Cliquer sur "Enregistrer la Dépense"

**Résultat attendu:** Dépense créée, affichée sur le tableau

### Test 4: Filtrage des Dépenses

**Étapes:**

1. Aller sur "Mes Dépenses"
2. Sélectionner une catégorie dans le filtre
3. Cliquer sur "Filtrer"

**Résultat attendu:** Affichage uniquement des dépenses de cette catégorie

### Test 5: Modifier une Dépense

**Étapes:**

1. Sur "Mes Dépenses", cliquer sur "✎ Modifier"
2. Modifier le montant: "75.50"
3. Cliquer sur "Enregistrer les modifications"

**Résultat attendu:** Dépense mise à jour

### Test 6: Supprimer une Dépense

**Étapes:**

1. Sur "Mes Dépenses", cliquer sur "🗑 Supprimer"
2. Confirmer la suppression

**Résultat attendu:** Dépense supprimée

### Test 7: Tableau de Bord

**Étapes:**

1. Ajouter plusieurs dépenses dans différentes catégories
2. Aller sur "Tableau de Bord"
3. Vérifier:
   - Total mensuel
   - Dépense la plus haute
   - Graphique de répartition

## 🔐 Test de Sécurité

### Test 1: Accès non authentifié

**Étapes:**

1. Tenter d'accéder à `http://localhost/gest_depes/dashbordd.php` sans être connecté

**Résultat attendu:** Redirection vers connexion.php

### Test 2: Injection SQL

**Étapes:**

1. Essayer d'entrer un code SQL malveillant dans un formulaire
   Exemple: `' OR '1'='1`

**Résultat attendu:** Le code est échappé et traité comme du texte normal

### Test 3: Modification d'une dépense d'un autre utilisateur

**Étapes:**

1. Avoir 2 comptes ouverts
2. Essayer de modifier l'ID d'une dépense d'un autre utilisateur dans l'URL

**Résultat attendu:** Impossible de modifier (contrôle user_id)

## 📊 Structure de Données

### Table: users

```
id              INT PRIMARY KEY AUTO_INCREMENT
nom             VARCHAR(100)
email           VARCHAR(100) UNIQUE
mot_de_passe    VARCHAR(255) - HASHÉ
date_creation   TIMESTAMP
```

### Table: categories

```
id              INT PRIMARY KEY AUTO_INCREMENT
nom             VARCHAR(50) UNIQUE
description     TEXT (optionnel)
icon            VARCHAR(50)
couleur         VARCHAR(7)
```

### Table: depenses

```
id              INT PRIMARY KEY
user_id         INT FOREIGN KEY → users(id)
montant         DECIMAL(10,2)
description     TEXT
categorie_id    INT FOREIGN KEY → categories(id)
date_depense    DATE
date_creation   TIMESTAMP
```

## 🎨 Fonctionnalités du Frontend

✅ **Responsive Design** - Fonctionne sur mobile, tablet et desktop
✅ **Graphiques interactifs** - Chart.js pour les statistiques
✅ **Validation formulaires** - Vérification client et serveur
✅ **Filtrage avancé** - Par catégorie et par mois
✅ **Interface moderne** - Design épuré et intuitif
✅ **Accessibilité** - HTML5 sémantique

## 🛠️ Commandes Utiles

### Réinitialiser la Base de Données

```bash
# Supprimer la BD
mysql -u root -e "DROP DATABASE gestion_depenses;"

# Réinstaller
# Accéder à install.php
http://localhost/gest_depes/install.php
```

### Vérifier les Données

```sql
-- Afficher tous les utilisateurs
SELECT * FROM users;

-- Afficher toutes les dépenses
SELECT * FROM depenses;

-- Afficher les dépenses d'un utilisateur
SELECT * FROM depenses WHERE user_id = 1;

-- Total des dépenses du mois courant
SELECT SUM(montant) FROM depenses
WHERE user_id = 1
  AND MONTH(date_depense) = MONTH(NOW())
  AND YEAR(date_depense) = YEAR(NOW());
```

## ⚠️ Problèmes Courants

### Erreur: "Connection failed"

**Solution:** Vérifier les paramètres de connexion dans `config.php`

### Erreur: "Email already used"

**Solution:** Cet email existe déjà. Utilisez une adresse email différente.

### Dépense n'apparaît pas

**Solution:** Vérifier que la date de dépense correspond au filtre appliqué

### Graphique ne s'affiche pas

**Solution:** Vérifier que Chart.js est correctement chargé (connexion internet)

## 📞 Support

Pour toute question, consultez le fichier README.md ou la documentation en ligne.
