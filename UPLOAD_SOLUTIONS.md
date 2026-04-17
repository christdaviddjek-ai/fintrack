# 📤 Guide d'Upload - Solutions Alternatives

Erreur rencontrée: `Unexpected token 'A', "Authentica"... is not valid JSON`

Cette erreur suggère un problème avec les credentials FTP. Voici **3 solutions** (du plus simple au plus technique):

---

## ✅ **SOLUTION 1: FileZilla (Recommandé - Interface Graphique)**

### Avantages
- ✅ Pas de ligne de commande
- ✅ Meilleure gestion des erreurs
- ✅ Affiche les fichiers distants
- ✅ Plus sûr (pas de stockage de mot de passe)

### Étapes

1. **Télécharge FileZilla**: https://filezilla-project.org/
2. **Ouvre FileZilla**
3. **Remplis les champs**:
   ```
   Host: tusite.infinityfree.net
   Username: if0_41685322
   Password: [Ton mot de passe FTP]
   Port: 21
   ```
4. **Clique "Quickconnect"**
5. **À gauche** (Local site): sélectionne `C:\wamp64\www\gest_depes`
6. **À droite** (Remote site): `public_html`
7. **Sélectionne ces fichiers à gauche**:
   ```
   google_callback.php       (NOUVEAU)
   google_config.php         (NOUVEAU avec TES clés)
   inscription.php           (MODIFIÉ)
   connexion.php             (MODIFIÉ)
   profil.php                (NOUVEAU)
   styles.css                (MODIFIÉ)
   ```
8. **Clique droit** → "Upload"
9. **Attends** le message vert "226 Transfer complete"

---

## ✅ **SOLUTION 2: Script Python Amélioré**

Si tu préfères la ligne de commande:

```bash
python ftp_upload_advanced.py
```

### Avant d'exécuter:
**Édite `ftp_upload_advanced.py`** et change:
```python
FTP_HOST = "tusite.infinityfree.net"    # Remplace par TON domaine
FTP_USER = "if0_41685322"               # Remplace par TON identifiant
FTP_PASSWORD = "ton_password"           # Remplace par TON mot de passe
```

### Résolution des erreurs JSON:
Le script affiche maintenant:
- ✅ Test de connexion FTP avant upload
- ✅ Messages clairs si le mot de passe est incorrect
- ✅ Détails de chaque fichier uploadé

---

## ✅ **SOLUTION 3: Panneau de Contrôle InfinityFree (Le Plus Sûr)**

Si les 2 solutions précédentes échouent:

1. **Accède au panneau**: https://members.infinityfree.net
2. **Onglet "Gestionnaire de fichiers"**
3. **Navigue à `/public_html`**
4. **Clique "Upload"** (bouton en haut)
5. **Sélectionne les fichiers** (multi-sélection avec Ctrl+Click):
   ```
   google_callback.php
   google_config.php (avec TES clés!)
   inscription.php
   connexion.php
   profil.php
   styles.css
   ```
6. **Clique "Upload"**
7. **Attends** la confirmation

---

## 🔑 **IMPORTANT: google_config.php**

⚠️ **NE PUSH PAS SUR GITHUB** avant de remplir `google_config.php`!

**Avant upload**, édite `google_config.php`:
```php
define('GOOGLE_CLIENT_ID', 'TON_CLIENT_ID.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'TON_SECRET');
define('GOOGLE_REDIRECT_URI', 'https://tonsite.infinityfree.net/google_callback.php');
```

---

## 🆘 **Dépannage**

### Erreur: "530 User authentication failed"
- ❌ Mauvais identifiant ou mot de passe
- ✅ Vérifie sur https://members.infinityfree.net

### Erreur: "Connection refused"
- ❌ FTP n'est pas activé sur InfinityFree
- ✅ Active-le dans le panneau de contrôle

### Fichiers uploadés mais la page ne change pas
- ❌ Cache navigateur
- ✅ Appuie sur `Ctrl+F5` (rafraîchissement forcé)

---

## ✅ Fichiers à Uploader (Mise à Jour Complète)

```
DOSSIER: /public_html

Core:
  - index.html
  - config.php
  - security.php
  - logout.php

Auth (NOUVEAU):
  - inscription.php
  - connexion.php
  - google_callback.php ⭐ NOUVEAU
  - google_config.php ⭐ NOUVEAU (avec TES clés!)

Dashboard:
  - dashbordd.php
  - crud_depense.php
  - profil.php ⭐ NOUVEAU
  - ajouter.php
  - modifier.php
  - supprimer.php

Frontend:
  - styles.css
  - script.js
```

---

**👉 Recommandation**: Utilise **FileZilla** (Solution 1) pour le moins de problèmes!
