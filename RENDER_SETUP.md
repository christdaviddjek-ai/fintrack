# fintrack - Configuration Render

## 🚀 Étapes de configuration sur Render

### 1. **Créer une MySQL Database**

- Sur Render dashboard → "New" → "MySQL"
- Nom: `fintrack-db`
- Noter les credentials

### 2. **Créer un Web Service**

- "New" → "Web Service"
- Connecter repo GitHub `fintrack`
- **Build Command**: `echo "Ready"`
- **Start Command**: `php -S 0.0.0.0:10000`

### 3. **Ajouter les variables d'environnement**

Dans le Web Service, aller à "Environment":

```
DB_HOST = (hostname MySQL de Render)
DB_PORT = 3306
DB_NAME = (database name)
DB_USER = (username)
DB_PASSWORD = (password)
```

### 4. **Initialiser la base de données**

Une fois le service déployé:

- Aller sur: `https://fintrack-xxxx.onrender.com/install.php`
- Cliquer pour créer les tables

### 5. **Utiliser l'app**

- Accueil: `https://fintrack-xxxx.onrender.com/index.html`
- Inscription: `https://fintrack-xxxx.onrender.com/inscription.php`
- Connexion: `https://fintrack-xxxx.onrender.com/connexion.php`

## ⚠️ Notes importantes

- Le service gratuit Render s'endort après 15min d'inactivité
- Première requête peut être lente (wake-up)
- Les logs sont visibles dans le dashboard

## 🐛 Dépannage

**"Cannot connect to database"**
→ Vérifier les credentials dans Environment Variables

**"Page blanche"**
→ Vérifier les logs Render (Dashboard > Service > Logs)

**"Permission denied"**
→ S'assurer que config.php peut lire les variables d'environnement
