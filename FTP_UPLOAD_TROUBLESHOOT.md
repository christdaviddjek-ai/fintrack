# 🚀 Upload vers InfinityFree - Guide Complet

## ❌ Problème: "Authentica" JSON Error

Ça signifie que **les credentials FTP sont incorrects ou mal formatés**.

---

## ✅ Solution: Script Python Simple

J'ai créé `upload_to_infinityfree.py` - **ZÉRO JSON**, juste FTP basique.

### ÉTAPE 1: Configure le script

Ouvre `upload_to_infinityfree.py` et remplace les 3 lignes:

```python
FTP_HOST = "tusite.infinityfree.net"  # ← TON DOMAINE INFINITYFREE
FTP_USER = "if0_41685322"              # ← TON FTP USER
FTP_PASSWORD = "ton_password"           # ← TON FTP PASSWORD
```

### ÉTAPE 2: Trouve tes credentials

**Dans InfinityFree Control Panel:**
1. Va sur **Accounts** ou **My Websites**
2. Cherche **FTP Accounts** ou **FTP Details**
3. Tu verras quelque chose comme:
   ```
   Host: tusite.infinityfree.net
   User: if0_41685322
   Password: [ton password]
   ```

### ÉTAPE 3: Lance le script

```powershell
cd c:\wamp64\www\gest_depes
python upload_to_infinityfree.py
```

### ÉTAPE 4: Attends le résultat

Tu verras:
```
🔗 Connexion à tusite.infinityfree.net...
✅ Connecté!
📂 Dossier: /public_html
📤 Upload: index.html... ✅
📤 Upload: inscription.php... ✅
...
✅ UPLOAD TERMINÉ!
🌐 Accès: https://tonsite.infinityfree.net
```

---

## 🆘 Si ça ne marche pas:

### ❌ "Connection refused"
```
→ Le HOST est incorrect
→ Exemple: "tusite.infinityfree.net" n'existe pas
→ Utilise le HOST EXACT d'InfinityFree
```

### ❌ "Authentication failed"
```
→ Le USER ou PASSWORD est mauvais
→ Vérifie dans le Control Panel
→ Attention aux ESPACES/accents
```

### ❌ "530 Login incorrect"
```
→ Même cause: credentials mauvais
→ Essaie sur le site web d'InfinityFree d'abord
→ Confirm que FTP est activé
```

---

## 💡 Alternative: Utiliser FileZilla (GUI)

Si le script ne marche pas:

1. **Télécharge**: [FileZilla](https://filezilla-project.org)
2. **Ouvre FileZilla** → File → Site Manager
3. **Ajoute un site**:
   ```
   Host: tusite.infinityfree.net
   Protocol: FTP
   Port: 21
   User: if0_41685322
   Password: [ton password]
   ```
4. **Connecte** → Drag & drop les fichiers

---

## 📝 Fichiers à uploader (auto dans le script):

```
✅ index.html
✅ inscription.php
✅ connexion.php
✅ dashbordd.php
✅ crud_depense.php
✅ ajouter.php
✅ modifier.php
✅ supprimer.php
✅ config.php
✅ security.php
✅ install.php
✅ logout.php
✅ styles.css
✅ script.js
```

---

## 🎯 Résumé rapide:

```
1. Configure FTP_HOST, FTP_USER, FTP_PASSWORD dans le script
2. Lance: python upload_to_infinityfree.py
3. Attends que tous les fichiers soient uploadés
4. Accès: https://tonsite.infinityfree.net
5. Initialise BD: https://tonsite.infinityfree.net/install.php
6. Test: signup/login
7. DONE! 🎉
```

---

## ❓ Questions courantes:

**Q: Quel port FTP?**
A: 21 (standard). InfinityFree utilise aussi SFTP sur port 22 si disponible.

**Q: Mon password a des caractères spéciaux?**
A: Mets-le entre guillemets: `FTP_PASSWORD = "mon@pass!word"`

**Q: Combien de temps l'upload?**
A: ~30 secondes pour ~15 fichiers

**Q: Après upload, je fais quoi?**
A: Va sur `https://tonsite.infinityfree.net/install.php` pour créer les tables

---

**Besoin d'aide? Dis-moi le HOST, USER et PASSWORD exact (ou le message d'erreur) et je configure le script! 💬**
