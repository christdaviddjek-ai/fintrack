# ✅ Checklist Déploiement fintrack sur Render (PostgreSQL)

## 🎯 Objectif
Déployer fintrack avec PostgreSQL sur Render en 6 étapes simples.

---

## ÉTAPE 1️⃣: Créer la base de données PostgreSQL

### Sur Render.com:
1. ✅ Clique sur **"New +"** (en haut à droite)
2. ✅ Sélectionne **"PostgreSQL"**
3. ✅ Configure:
   - **Name**: `fintrack_db`
   - **Region**: `Oregon` (ou proche de toi)
   - **PostgreSQL Version**: `18` (garder défaut)
   - **Plan**: `Free` (gratuit)
   - **Storage**: `15 GB`
4. ✅ Clique **"Create Database"**
5. ⏳ **ATTENDS 2-3 minutes** (PostgreSQL se lance)

### 📝 Une fois créé:
- Tu verras une page avec tes credentials
- **COPIE ces 4 valeurs:**

```
🔗 Host: dpg-xxxxx.render.com
📦 Database: fintrack_db
👤 Username: fintrack_user
🔑 Password: abc123xyz...
```

✅ **Sauvegarde ces valeurs** - Tu en auras besoin à l'étape 3!

---

## ÉTAPE 2️⃣: Créer le Web Service

### Sur Render.com (Dashboard):
1. ✅ Clique sur **"New +"**
2. ✅ Sélectionne **"Web Service"**
3. ✅ **Connecte ton repo GitHub:**
   - Clique **"Connect a repository"**
   - Trouve et sélectionne `fintrack`
   - Clique **"Connect"**

### Configure le service:
4. ✅ Remplis les champs:
   - **Name**: `fintrack` (ou `fintrack-app`)
   - **Environment**: `Docker` (ou `PHP` si dispo)
   - **Region**: `Oregon` (**MÊME que PostgreSQL!**)
   - **Build Command**: `echo "Ready"`
   - **Start Command**: `php -S 0.0.0.0:10000`
   - **Plan**: `Free`

5. ✅ **NE clique PAS "Deploy" encore!**
   - Continue à l'étape 3 d'abord

---

## ÉTAPE 3️⃣: Ajouter les variables d'environnement

### Avant de déployer:
1. ✅ Dans le Web Service, onglet **"Environment"**
2. ✅ Ajoute ces 6 variables (copie tes valeurs PostgreSQL):

| Variable | Valeur |
|----------|--------|
| `DB_HOST` | `dpg-xxxxx.render.com` (ta valeur Host) |
| `DB_PORT` | `5432` (toujours 5432 pour PostgreSQL) |
| `DB_NAME` | `fintrack_db` (ta valeur Database) |
| `DB_USER` | `fintrack_user` (ta valeur Username) |
| `DB_PASSWORD` | `abc123xyz...` (ta valeur Password) |
| `DB_TYPE` | `postgres` |

3. ✅ Clique **"Save"**

### 🚀 Render va automatiquement:
- Redéployer l'app
- Injector les variables
- Attendre 2-3 minutes...

---

## ÉTAPE 4️⃣: Vérifier le déploiement

### Voir le statut:
1. ✅ Dans le Web Service, tu verras un statut:
   - 🟢 **"Live"** = Succès! ✅
   - 🟡 **"Deploying"** = En cours, attends...
   - 🔴 **"Failed"** = Erreur, check les logs

### Si erreur:
- Clique **"Logs"** pour voir les messages d'erreur
- Vérifie que les variables d'environnement sont correctes
- Vérifie que DB_HOST est accessible

---

## ÉTAPE 5️⃣: Initialiser la base de données

### Une fois le service "Live":
1. ✅ Accède à: `https://fintrack-xxxx.onrender.com/install_postgres.php`
   - Remplace `xxxx` par le nom réel de ton service
2. ✅ Tu verras: **✅ "Installation PostgreSQL réussie!"**
   - Cela signifie que les tables ont été créées
3. ✅ Les 7 catégories ont été insérées automatiquement

---

## ÉTAPE 6️⃣: Tester l'application

### L'app est maintenant live! 🎉

| Page | URL |
|------|-----|
| **Accueil** | `https://fintrack-xxxx.onrender.com/index.html` |
| **S'inscrire** | `https://fintrack-xxxx.onrender.com/inscription.php` |
| **Se connecter** | `https://fintrack-xxxx.onrender.com/connexion.php` |
| **Dashboard** | `https://fintrack-xxxx.onrender.com/dashbordd.php` |
| **Health Check** | `https://fintrack-xxxx.onrender.com/health.php` |

### Test rapide:
1. ✅ Va sur `/inscription.php`
2. ✅ Crée un compte (nom, email, password, revenu)
3. ✅ Connecte-toi
4. ✅ Ajoute une dépense
5. ✅ Voir le dashboard avec les stats

---

## 🔧 Dépannage

### ❌ Erreur: "Connection refused"
```
→ Vérifier que les variables d'environnement sont correctes
→ Vérifier que PostgreSQL est "Live" sur Render
→ Relancer: Logs → redeploy
```

### ❌ Erreur: "Database not found"
```
→ Aller sur /install_postgres.php pour créer les tables
→ Vérifier que DB_NAME est correct
```

### ❌ Page blanche
```
→ Check les Logs du Web Service
→ Vérifier que PHP est bien configuré
→ Vérifier le Start Command: php -S 0.0.0.0:10000
```

### ❌ "Web Service crashed"
```
→ Aller dans Logs
→ Chercher les erreurs PHP
→ Redeploy ou redémarrer le service
```

---

## 📱 Auto-redéploiement (GitHub)

### À chaque push sur GitHub:
1. ✅ Tu pushes du code: `git push`
2. ✅ Render détecte le changement
3. ✅ Render redéploie automatiquement
4. ✅ L'app se met à jour en live (0 downtime)

C'est pour ça que c'est cool! 🚀

---

## ✅ Résumé des credentials

Une fois tout déployé:
- 🌍 **Domaine**: `https://fintrack-xxxx.onrender.com`
- 🗄️ **BD**: PostgreSQL sur Render
- 🔐 **Variables**: Toutes dans "Environment" du Web Service
- 📝 **Logs**: Accessible depuis le dashboard Render

---

## 🎉 Succès!

Si tu vois:
1. ✅ PostgreSQL "Live"
2. ✅ Web Service "Live"
3. ✅ Installation page avec "✅ Installation réussie!"
4. ✅ Signup/Login fonctionnent
5. ✅ Dashboard affiche les stats

**Alors fintrack est déployé avec succès!** 🚀🎊

