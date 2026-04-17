#!/usr/bin/env python3
"""
Script d'upload FTP automatique pour InfinityFree
Upload tous les fichiers du projet vers public_html
"""

import ftplib
import os
import sys
from pathlib import Path

# ═════════════════════════════════════════════════════════════════
# CONFIGURATION - À MODIFIER AVEC TES INFOS INFINITYFREE
# ═════════════════════════════════════════════════════════════════

FTP_HOST = "tusite.infinityfree.net"  # Remplace par ton domaine
FTP_USER = "if0_41685322"              # Remplace par ton user
FTP_PASS = "ton_password_ftp"           # Remplace par ton password FTP
FTP_PORT = 21                           # Port FTP (21 par défaut)

# Dossier local (le projet fintrack)
LOCAL_DIR = r"C:\wamp64\www\gest_depes"

# Dossier distant (public_html sur InfinityFree)
REMOTE_DIR = "/public_html"

# Fichiers à uploader
FILES_TO_UPLOAD = [
    "index.html",
    "inscription.php",
    "connexion.php",
    "dashbordd.php",
    "crud_depense.php",
    "ajouter.php",
    "modifier.php",
    "supprimer.php",
    "config.php",
    "security.php",
    "logout.php",
    "install.php",
    "styles.css",
    "script.js",
    ".gitignore",
]

# ═════════════════════════════════════════════════════════════════

def upload_files():
    """Upload tous les fichiers via FTP"""
    
    print("=" * 60)
    print("📤 Upload FTP - fintrack vers InfinityFree")
    print("=" * 60)
    
    try:
        # Connexion FTP
        print(f"\n🔗 Connexion à {FTP_HOST}...")
        ftp = ftplib.FTP(FTP_HOST, FTP_USER, FTP_PASS)
        ftp.encoding = 'utf-8'
        print("✅ Connecté!")
        
        # Aller dans public_html
        print(f"📁 Navigation vers {REMOTE_DIR}...")
        ftp.cwd(REMOTE_DIR)
        print("✅ Dans public_html")
        
        # Upload chaque fichier
        print(f"\n📤 Upload de {len(FILES_TO_UPLOAD)} fichiers...\n")
        
        for file in FILES_TO_UPLOAD:
            local_path = os.path.join(LOCAL_DIR, file)
            
            if not os.path.exists(local_path):
                print(f"⚠️  {file}: MANQUANT (skip)")
                continue
            
            try:
                with open(local_path, 'rb') as f:
                    ftp.storbinary(f'STOR {file}', f)
                print(f"✅ {file} (OK)")
            except Exception as e:
                print(f"❌ {file}: {str(e)}")
        
        # Fermer connexion
        ftp.quit()
        
        print("\n" + "=" * 60)
        print("✅ UPLOAD TERMINÉ!")
        print("=" * 60)
        print(f"\n📍 Accès: https://{FTP_HOST.replace('infinityfree.net', '')}/index.html")
        print("\n⚠️  N'OUBLIE PAS:")
        print("   1. Va sur /install.php pour créer les tables")
        print("   2. Test signup/login")
        print("\n")
        
    except ftplib.all_errors as e:
        print(f"\n❌ ERREUR FTP: {str(e)}")
        print("\n🔍 Vérifie:")
        print(f"   • Host: {FTP_HOST}")
        print(f"   • User: {FTP_USER}")
        print(f"   • Password: correct?")
        print(f"   • Port: {FTP_PORT}")
        sys.exit(1)
    except Exception as e:
        print(f"\n❌ ERREUR: {str(e)}")
        sys.exit(1)

if __name__ == "__main__":
    upload_files()
