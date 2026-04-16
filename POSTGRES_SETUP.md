# 📱 Guide d'installation fintrack sur Render avec PostgreSQL

## 🎯 Vue d'ensemble
Ce guide explique comment déployer l'application **fintrack** sur Render avec une base de données PostgreSQL.

---

## 📋 Étapes à suivre

### 1️⃣ Créer la base de données PostgreSQL

1. Accéder à [Render Dashboard](https://render.com/dashboard)
2. Cliquer sur **"New +"** → **"PostgreSQL"**
3. Remplir les champs:
   - **Name**: `fintrack-db`
   - **Region**: Sélectionner la région la plus proche
   - **PostgreSQL Version**: Garder la version par défaut
4. Cliquer sur **"Create Database"**
5. **Attendre 2-3 minutes** pour que PostgreSQL soit prêt
6. Une fois créé, **copier les informations de connexion**:
   - Hostname (ex: `dpg-xxx.render.com`)
   - Database (ex: `fintrack_db`)
   - Username (ex: `fintrack_user`)
   - Password (généré automatiquement)

---

### 2️⃣ Créer le Web Service

1. Cliquer sur **"New +"** → **"Web Service"**
2. **Connecter le GitHub repo**:
   - Cliquer sur **"Connect a repository"**
   - Sélectionner le repo `fintrack`
3. Remplir les champs:
   - **Name**: `fintrack`
   - **Environment**: Sélectionner **"Docker"** (ou **"PHP"** si disponible)
   - **Build Command**: `echo "Ready"`
   - **Start Command**: `php -S 0.0.0.0:10000`
   - **Plan**: Free
   - **Region**: Même région que la BD

---

### 3️⃣ Ajouter les variables d'environnement

1. Dans le Web Service, aller à l'onglet **"Environment"**
2. Ajouter les variables (depuis les credentials PostgreSQL copied):

| Variable | Valeur |
|----------|--------|
| `DB_HOST` | Hostname de PostgreSQL |
| `DB_PORT` | `5432` |
| `DB_NAME` | Database name |
| `DB_USER` | Username |
| `DB_PASSWORD` | Password |
| `DB_TYPE` | `postgres` |

3. Cliquer sur **"Save"**
4. Render va **automatiquement redéployer** l'app

---

### 4️⃣ Initialiser la base de données

1. Attendre que le service soit déployé (2-3 minutes)
2. Aller sur: `https://fintrack-xxxx.onrender.com/install_postgres.php`
3. Si tout va bien:
   - ✅ Vous verrez: **"Installation PostgreSQL réussie!"**
   - Les tables et catégories seront créées

---

### 5️⃣ Accéder à l'application

Une fois déployé et initialisé:

- **Accueil**: `https://fintrack-xxxx.onrender.com/index.html`
- **Inscription**: `https://fintrack-xxxx.onrender.com/inscription.php`
- **Connexion**: `https://fintrack-xxxx.onrender.com/connexion.php`
- **Health Check**: `https://fintrack-xxxx.onrender.com/health.php`

---

## 🔧 Dépannage

### ❌ Erreur: "Connection refused"
→ Vérifier que les variables d'environnement sont correctes
→ Vérifier que PostgreSQL est bien créé et accessible

### ❌ Erreur: "Database not found"
→ Aller sur `/install_postgres.php` pour initialiser

### ❌ Les filtres ne fonctionnent pas
→ Vérifier que `DB_TYPE=postgres` est défini
→ La fonction `convertSQL()` transforme les requêtes automatiquement

---

## 📝 Notes importantes

- **Auto-redéploiement**: À chaque push sur GitHub, Render redéploie automatiquement
- **PostgreSQL gratuit**: Limité à 90 jours de gratuité, puis suppression
- **Migrations futures**: Si besoin de changer de MySQL vers PostgreSQL (ou vice-versa), il suffit de modifier `DB_TYPE` et redéployer

---

## ✅ Vérifier le déploiement

Pour voir les logs et vérifier que tout fonctionne:

1. Aller dans le Web Service → **Logs**
2. Chercher les messages de succès
3. Vérifier que les requêtes PHP s'exécutent correctement

Bonne chance! 🚀
