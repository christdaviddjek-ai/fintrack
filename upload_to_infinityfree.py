#!/usr/bin/env python3
"""
Upload files to InfinityFree via FTP
Simple & robust - no JSON parsing issues
"""

import ftplib
import os
import sys
from pathlib import Path

# ============================================
# CONFIGURE THESE WITH YOUR FTP CREDENTIALS
# ============================================
FTP_HOST = "tusite.infinityfree.net"  # CHANGE THIS
FTP_USER = "if0_41685322"              # CHANGE THIS
FTP_PASSWORD = "ton_password"           # CHANGE THIS
FTP_REMOTE_PATH = "/public_html"        # Leave as is

# ============================================
# FILES TO UPLOAD
# ============================================
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
    "install.php",
    "logout.php",
    "styles.css",
    "script.js",
]

def upload_files():
    """Upload files via FTP"""
    try:
        print(f"🔗 Connexion à {FTP_HOST}...")
        ftp = ftplib.FTP(FTP_HOST, FTP_USER, FTP_PASSWORD)
        print("✅ Connecté!")
        
        # Change to public_html
        ftp.cwd(FTP_REMOTE_PATH)
        print(f"📂 Dossier: {FTP_REMOTE_PATH}")
        
        # Upload each file
        for file in FILES_TO_UPLOAD:
            if os.path.exists(file):
                print(f"📤 Upload: {file}...", end=" ")
                with open(file, 'rb') as f:
                    ftp.storbinary(f'STOR {file}', f)
                print("✅")
            else:
                print(f"⚠️  {file} NOT FOUND (skipped)")
        
        ftp.quit()
        print("\n✅ UPLOAD TERMINÉ!")
        print("🌐 Accès: https://tonsite.infinityfree.net")
        
    except ftplib.all_errors as e:
        print(f"\n❌ ERREUR FTP: {e}")
        sys.exit(1)

if __name__ == "__main__":
    # Check if credentials are configured
    if "tusite.infinityfree.net" in FTP_HOST:
        print("❌ ERREUR: Configure FTP_HOST, FTP_USER, FTP_PASSWORD d'abord!")
        print("\nVois les instructions dans INFINITY_FREE_DEPLOY.md")
        sys.exit(1)
    
    upload_files()
