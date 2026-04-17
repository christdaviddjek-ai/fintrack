# 📤 Guide Upload FTP - Alternative au File Manager

Si le **File Manager web d'InfinityFree** ne fonctionne pas, voici des **solutions robustes** pour uploader tes fichiers.

---

## 🎯 3 Solutions (du plus simple au plus technique)

### ✅ Solution 1: Script Batch (Windows - Plus facile!)

**Étape 1: Récupérer tes infos FTP**
- Va sur [InfinityFree Control Panel](https://infinityfree.net)
- **FTP Accounts** → Tu verras:
  ```
  Host: tusite.infinityfree.net
  User: if0_41685322 (ou similaire)
  Password: [ton FTP password]
  ```

**Étape 2: Modifier le script batch**
- Ouvre `upload_ftp.bat` (dans le dossier du projet)
- Modifie les lignes:
  ```batch
  set FTP_HOST=tusite.infinityfree.net      # ← Ton domaine
  set FTP_USER=if0_41685322                  # ← Ton user
  set FTP_PASS=ton_password_ftp              # ← Ton password FTP
  ```

**Étape 3: Exécuter**
```powershell
cd C:\wamp64\www\gest_depes
.\upload_ftp.bat
```

✅ **Les fichiers sont uploadés automatiquement!**

---

### ✅ Solution 2: Script Python (Windows/Mac/Linux)

**Étape 1: Même infos FTP (voir ci-dessus)**

**Étape 2: Modifier le script Python**
- Ouvre `upload_ftp.py`
- Modifie les lignes:
  ```python
  FTP_HOST = "tusite.infinityfree.net"
  FTP_USER = "if0_41685322"
  FTP_PASS = "ton_password_ftp"
  ```

**Étape 3: Exécuter**
```powershell
cd C:\wamp64\www\gest_depes
python upload_ftp.py
```

✅ **Plus de détails et meilleur feedback!**

---

### ✅ Solution 3: FileZilla (Interface graphique)

**Étape 1: Télécharger FileZilla**
- [https://filezilla-project.org](https://filezilla-project.org)
- Installation standard

**Étape 2: Configuration**
```
Host: sftp://tusite.infinityfree.net  (SFTP = plus sécurisé)
User: if0_41685322
Password: [ton FTP password]
Port: 22 (SFTP) ou 21 (FTP)
```

**Étape 3: Drag & drop**
- À gauche: Dossier local (`C:\wamp64\www\gest_depes`)
- À droite: `/public_html`
- Sélectionne tous les fichiers + Drag & drop

✅ **Visuel et contrôlé!**

---

## 🚨 Troubleshooting

### ❌ "Connection refused"
```
→ Vérifier que FTP est activé (InfinityFree Control Panel)
→ Attendre 5-10 minutes (propagation)
→ Essayer le port 21 au lieu de 22
```

### ❌ "Permission denied"
```
→ Les permissions public_html peuvent être strictes
→ Essayer FileZilla avec SFTP (port 22)
```

### ❌ "Invalid credentials"
```
→ Vérifier que tu utilises le FTP password (pas le vPanel password)
→ Control Panel → FTP Accounts → Reset password
```

### ❌ "File not found" (en script)
```
→ Vérifier que les fichiers existent dans C:\wamp64\www\gest_depes
→ Vérifier le chemin LOCAL_DIR
```

---

## 📝 Résumé

| Méthode | Difficulté | Vitesse | Recommandé |
|---------|-----------|---------|-----------|
| Batch | ⭐ | ⚡ | ✅ Windows |
| Python | ⭐ | ⚡ | ✅ Cross-platform |
| FileZilla | ⭐⭐ | 🐢 | ✅ Visuel |
| File Manager | ⭐⭐⭐ | 🐢 | ❌ Buggé |

---

## ✅ Après l'upload

1. **Initialiser BD**: `https://tusite.infinityfree.net/install.php`
2. **Tester**: `https://tusite.infinityfree.net/inscription.php`
3. **Enjoy!** 🎉

---

## 💡 Tips

- Les scripts modifient **seulement** les fichiers nécessaires
- Pas de suppression accidentelle de fichiers existants
- Peux relancer l'upload autant de fois que tu veux
- Chaque upload remplace la version précédente

---

## 🆘 Besoin d'aide?

Si les scripts ne fonctionnent pas:
1. Copie/colle le **message d'erreur exact**
2. Dis-moi **quel script** tu as essayé
3. Je t'aide à le fixer! 💬

---

Bonne chance! 🚀
