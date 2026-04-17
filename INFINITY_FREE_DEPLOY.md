# 🚀 Déployer fintrack sur InfinityFree

## ✅ Config déjà prête

fintrack est configuré pour InfinityFree MySQL:
```php
Host: sql100.infinityfree.com
Database: if0_41685322_fintrack
User: if0_41685322
```

---

## 📋 4 étapes simples

### ÉTAPE 1: Uploader les fichiers

1. Va sur [InfinityFree Control Panel](https://infinityfree.net)
2. Login avec tes credentials
3. **File Manager** → Ouvre `public_html`
4. Upload TOUS les fichiers:
   - ✅ Tous les `.php`
   - ✅ `styles.css`
   - ✅ `script.js`
   - ✅ `index.html`
   - ✅ `.gitignore`

Structure finale:
```
public_html/
├── index.html
├── inscription.php
├── connexion.php
├── dashbordd.php
├── crud_depense.php
├── ajouter.php
├── modifier.php
├── supprimer.php
├── config.php
├── security.php
├── install.php
├── logout.php
├── styles.css
├── script.js
└── .gitignore
```

---

### ÉTAPE 2: Vérifier la BD MySQL

**InfinityFree fournit déjà MySQL!**

Dans Control Panel:
1. **Databases** section
2. Tu verras:
   - Host: `sql100.infinityfree.com`
   - Database: `if0_41685322_fintrack`
   - User: `if0_41685322`
   - Password: [Ton password]

✅ C'est déjà configuré dans `config.php`

---

### ÉTAPE 3: Initialiser la BD

1. Accès: `https://tonsite.infinityfree.net/install.php`
   - Remplace `tonsite` par ton domaine
2. Clique le lien ou la page s'exécute auto
3. Tu verras: **✅ "Installation réussie!"**
   - Tables `users`, `categories`, `depenses` créées
   - 7 catégories insérées

---

### ÉTAPE 4: Tester l'app

1. **Homepage**: `https://tonsite.infinityfree.net/index.html`
2. **S'inscrire**: Crée un compte test
   - Nom, Email, Password, Revenu
3. **Se connecter**: Login avec ton compte
4. **Dashboard**: Voir les stats
5. **Ajouter dépense**: Test complet

---

## 🎯 URLs essentielles

| Page | URL |
|------|-----|
| Accueil | `https://tonsite.infinityfree.net/index.html` |
| Inscription | `https://tonsite.infinityfree.net/inscription.php` |
| Connexion | `https://tonsite.infinityfree.net/connexion.php` |
| Dashboard | `https://tonsite.infinityfree.net/dashbordd.php` |
| Dépenses | `https://tonsite.infinityfree.net/crud_depense.php` |
| Install BD | `https://tonsite.infinityfree.net/install.php` |

---

## 🔒 Sécurité

✅ Tout est sécurisé:
- CSRF tokens
- Rate limiting (5 tentatives/15min)
- Password hashing
- SQL injection prevention
- Variables d'environnement
- .gitignore pour credentials

---

## 🆘 Problèmes?

### ❌ "Connection refused"
```
→ Vérifier que la BD MySQL est créée
→ Vérifier les credentials dans config.php
→ Attendre 5 min (propagation)
```

### ❌ "Table not found"
```
→ Aller sur /install.php
→ Créer les tables
```

### ❌ Page blanche
```
→ Vérifier les Logs InfinityFree (Control Panel)
→ Vérifier que PHP est activé
```

---

## 📝 Résumé

```
1. Upload tous les fichiers dans public_html
2. BD MySQL déjà créée (InfinityFree)
3. Accès /install.php pour initialiser
4. Test signup/login
5. App live! 🎉
```

**Temps: ~10-15 minutes**

---

## ✅ Prêt?

1. Upload les fichiers
2. Initialise la BD
3. Test signup/login
4. Prêt à utiliser! 🚀

Besoin d'aide? 💬
