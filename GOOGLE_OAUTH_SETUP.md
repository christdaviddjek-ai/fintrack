# 🔐 Configuration Google OAuth 2.0

## 📋 Étapes d'Installation

### ÉTAPE 1: Créer un Google Cloud Project

1. Va sur [Google Cloud Console](https://console.cloud.google.com/)
2. Crée un nouveau projet (nom: "fintrack")
3. Attends que le projet se crée

---

### ÉTAPE 2: Activer l'API Google+ 

1. **APIs & Services** → Bibliothèque
2. Cherche **"Google+ API"**
3. Clique **"Activer"**

---

### ÉTAPE 3: Créer des Credentials OAuth 2.0

1. **APIs & Services** → Identifiants
2. Clique **"Créer des identifiants"** → **"ID client OAuth"**
3. Sélectionne **"Application web"**
4. Nom: "fintrack"

---

### ÉTAPE 4: Ajouter les URIs Autorisés

Dans la section **"URIs JavaScript autorisés"**:
```
https://tonsite.infinityfree.net
http://localhost:8000 (pour tests locaux)
```

Dans la section **"URIs de redirection autorisés"**:
```
https://tonsite.infinityfree.net/google_callback.php
http://localhost:8000/google_callback.php (tests locaux)
```

---

### ÉTAPE 5: Récupérer tes Credentials

La console affiche:
```
Client ID: xxxxxx.apps.googleusercontent.com
Client Secret: xxxxxx
```

---

## 🔧 Configurer google_config.php

Édite `google_config.php` et remplace:

```php
define('GOOGLE_CLIENT_ID', 'TON_CLIENT_ID.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'TON_CLIENT_SECRET');
define('GOOGLE_REDIRECT_URI', 'https://tonsite.infinityfree.net/google_callback.php');
```

**Avec TES valeurs réelles!**

---

## ✅ Tester

1. Va sur **Inscription**
2. Clique **"Continuer avec Google"**
3. Autorise l'accès
4. Tu dois être créé et loggé automatiquement ✅

---

## 🎯 Fonctionnement

**1. Utilisateur clique "Continuer avec Google"**
   ↓
**2. Google demande l'autorisation**
   ↓
**3. Google redirige vers `google_callback.php` avec un code**
   ↓
**4. fintrack échange le code pour un access token**
   ↓
**5. fintrack récupère email + nom du compte Google**
   ↓
**6. Si utilisateur existe → Login**
   **Si nouveau → Créer compte + Login**

---

## 🔒 Sécurité

✅ Les credentials sont dans `google_config.php` (à ajouter au .gitignore)
✅ OAuth 2.0 flow sécurisé avec authorization code
✅ Mot de passe aléatoire généré (non utilisé si Google)
✅ Revenu par défaut = 0 (l'utilisateur peut le modifier)

---

## ⚠️ Important

### Ne pas commiter google_config.php!

Ajoute à `.gitignore`:
```
google_config.php
```

### Variables d'environnement (optionnel)

Pour plus de sécurité, tu peux utiliser des variables d'environnement:

```php
define('GOOGLE_CLIENT_ID', getenv('GOOGLE_CLIENT_ID'));
define('GOOGLE_CLIENT_SECRET', getenv('GOOGLE_CLIENT_SECRET'));
```

Et les définir dans le control panel InfinityFree.

---

## 📤 Fichiers à Uploader

```
✅ google_config.php         (avec TES clés)
✅ google_callback.php       (callback handler)
✅ inscription.php           (modifié - bouton Google)
✅ connexion.php             (modifié - bouton Google)
```

---

**Besoin d'aide?** 💬
