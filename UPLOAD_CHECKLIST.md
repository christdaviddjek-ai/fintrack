# ✅ Checklist Pré-Upload

Avant d'uploader sur InfinityFree, vérifie ceci:

## 🔑 Credentials FTP

- [ ] Tu as tes identifiants InfinityFree
  - Host: `tusite.infinityfree.net` (remplace `tusite` par TON domaine)
  - User: `if0_XXXXXX` (commence par `if0_`)
  - Password: Mot de passe FTP (PAS celui de login!)

- [ ] Les credentials FTP sont activés
  - Accès: https://members.infinityfree.net
  - Vérifie l'onglet "Upload Manager" ou "FTP Account"

## 🔐 Google OAuth

- [ ] Tu as tes clés Google API
  - Client ID
  - Client Secret

- [ ] `google_config.php` est REMPLI avec TES clés:
  ```php
  define('GOOGLE_CLIENT_ID', 'XXXXX.apps.googleusercontent.com');
  define('GOOGLE_CLIENT_SECRET', 'XXXXX');
  ```

- [ ] `google_config.php` n'est PAS dans `.gitignore`
  - Non! C'est SECRET! Il NE DOIT JAMAIS être sur GitHub

## 📁 Fichiers Locaux

Vérifie que ces fichiers existent en local:

**Essentiels:**
- [ ] `google_callback.php` (NOUVEAU)
- [ ] `google_config.php` (NOUVEAU - avec TES clés)
- [ ] `inscription.php` (MODIFIÉ - avec bouton Google)
- [ ] `connexion.php` (MODIFIÉ - avec bouton Google)
- [ ] `profil.php` (NOUVEAU)
- [ ] `styles.css` (MODIFIÉ - dark mode)

**Autres (si tu n'as jamais uploadé):**
- [ ] `config.php` (configuration DB)
- [ ] `security.php` (fonctions de sécurité)
- [ ] `dashbordd.php` (dashboard)
- [ ] `crud_depense.php` (liste des dépenses)
- [ ] `ajouter.php`, `modifier.php`, `supprimer.php` (CRUD)
- [ ] `index.html`, `styles.css`, `script.js` (frontend)
- [ ] `logout.php`, `install.php`

## 🚀 Prêt pour l'Upload?

- [ ] Tous les fichiers existent localement
- [ ] `google_config.php` contient TES clés API
- [ ] Tu as les credentials FTP prêts
- [ ] Pas d'erreurs dans `config.php` (teste en local d'abord)

## 📤 Pendant l'Upload

- [ ] Utilise **FileZilla** (plus simple et sûr)
- [ ] Ou le **Gestionnaire de Fichiers InfinityFree**
- [ ] Ou le **script Python** `ftp_upload_advanced.py`

## ✅ Après l'Upload

- [ ] Rafraîchis le site: `Ctrl+F5`
- [ ] Vérifie que tu vois les boutons "Continuer avec Google"
- [ ] Teste la connexion avec Google
- [ ] Si erreur de connexion:
  - Vérifie que `google_config.php` contient les bonnes clés
  - Vérifie l'URI de redirection dans Google Cloud Console

---

**👉 Problème d'upload?** Voir `UPLOAD_SOLUTIONS.md`
