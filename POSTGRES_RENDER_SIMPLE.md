# 🚀 PostgreSQL sur Render - Guide Simple

## ✅ Render n'offre que PostgreSQL (pas MySQL)

Pas de problème! fintrack supporte déjà PostgreSQL. Voici comment le déployer.

---

## 📋 5 étapes simples

### ÉTAPE 1: Créer PostgreSQL

1. Va sur [Render Dashboard](https://render.com/dashboard)
2. Clique **"New +"** (haut droit)
3. Sélectionne **"Postgres"** (c'est le seul choix BD)
4. Remplis:
   - **Name**: `fintrack-db`
   - **Region**: `Oregon`
   - **Plan**: `Free`
   - **Storage**: `15 GB`
5. Clique **"Create Database"**
6. ⏳ **Attends 2-3 minutes** jusqu'à 🟢 "Opérationnel"

---

### ÉTAPE 2: Copier les credentials

Une fois **"Opérationnel"**:

Onglet **"Connections"** ou clique le hostname → Tu verras:

```
🔗 Host: dpg-xxxxx.render.com
📦 Database: fintrack_db_xxxxx
👤 Username: fintrack_db_xxxxx_user
🔑 Password: [Clique l'œil]
🔌 Port: 5432
```

📝 **Copie ces 5 valeurs** dans un bloc-notes

---

### ÉTAPE 3: Créer Web Service

1. Clique **"New +"** → **"Web Service"**
2. Clique **"Connect a repository"**
3. Sélectionne `fintrack` (GitHub)
4. Configure:
   - **Name**: `fintrack`
   - **Region**: `Oregon` (MÊME que PostgreSQL!)
   - **Build**: `echo "Ready"`
   - **Start**: `php -S 0.0.0.0:10000`
   - **Plan**: `Free`

5. ⚠️ **NE CLIQUE PAS DEPLOY ENCORE!**

---

### ÉTAPE 4: Ajouter variables d'environnement

Avant de déployer:

1. Onglet **"Environment"**
2. Ajoute **6 variables** (colle TES credentials):

```
DB_HOST = dpg-xxxxx.render.com
DB_PORT = 5432
DB_NAME = fintrack_db_xxxxx
DB_USER = fintrack_db_xxxxx_user
DB_PASSWORD = [ton password]
DB_TYPE = postgres
```

3. Clique **"Save"**

Render redéploie automatiquement (2-3 min)

---

### ÉTAPE 5: Initialiser & Tester

Une fois 🟢 **"Live"**:

1. Accès: `https://fintrack-xxxx.onrender.com/install_postgres.php`
2. Tu verras: **✅ "Installation PostgreSQL réussie!"**
3. Clique **"→ Accéder à l'application"**
4. Test signup/login

✅ **C'est terminé!** 🎉

---

## 📝 Résumé rapide

```
1. Postgres → Create
2. Attends "Opérationnel"
3. Copie 5 credentials
4. Web Service + GitHub
5. Ajoute variables
6. Déploie
7. Install PostgreSQL
8. Test login
```

**Temps: ~20 minutes**

---

## 🆘 Aide?

- 📖 [FAQ_RENDER.md](FAQ_RENDER.md) - Questions fréquentes
- 📋 [RENDER_DEPLOYMENT_CHECKLIST.md](RENDER_DEPLOYMENT_CHECKLIST.md) - Détails
- 🔄 [NEXT_STEPS.md](NEXT_STEPS.md) - Étapes détaillées

Besoin d'aide à une étape? Dis-moi laquelle! 💬
