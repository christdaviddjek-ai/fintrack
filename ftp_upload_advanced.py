#!/usr/bin/env python3
"""
Upload files to InfinityFree via FTP - ADVANCED VERSION
Tests connection, handles errors, detailed logging
"""

import ftplib
import os
import sys
from pathlib import Path

# ============================================
# CONFIGURE THESE WITH YOUR FTP CREDENTIALS
# ============================================
FTP_HOST = "tusite.infinityfree.net"        # CHANGE THIS
FTP_USER = "if0_41685322"                   # CHANGE THIS
FTP_PASSWORD = "ton_password"                # CHANGE THIS
FTP_REMOTE_PATH = "/public_html"             # Leave as is

# ============================================
# FILES TO UPLOAD (UPDATED WITH GOOGLE OAUTH)
# ============================================
FILES_TO_UPLOAD = [
    # Core files
    "index.html",
    "config.php",
    "security.php",
    "logout.php",
    
    # Authentication
    "inscription.php",
    "connexion.php",
    "google_callback.php",      # NEW
    "google_config.php",        # NEW - with YOUR credentials
    
    # Dashboard & Expenses
    "dashbordd.php",
    "crud_depense.php",
    "ajouter.php",
    "modifier.php",
    "supprimer.php",
    "profil.php",               # NEW
    
    # Frontend
    "styles.css",
    "script.js",
    
    # Install (if needed)
    "install.php",
]

def test_ftp_connection():
    """Test FTP connection and return status"""
    try:
        print("🔍 Test de connexion FTP...")
        print(f"   Hôte: {FTP_HOST}")
        print(f"   Utilisateur: {FTP_USER}")
        
        ftp = ftplib.FTP(FTP_HOST, FTP_USER, FTP_PASSWORD, timeout=10)
        print("✅ Connexion réussie!")
        
        # Get current directory
        current_dir = ftp.pwd()
        print(f"   Dossier actuel: {current_dir}")
        
        # List files
        files = ftp.nlst()
        print(f"   Fichiers distants: {len(files)} trouvés")
        
        ftp.quit()
        return True
        
    except ftplib.all_errors as e:
        error_msg = str(e)
        print(f"❌ Erreur FTP: {error_msg}")
        
        # Parse error
        if "530" in error_msg or "Authentication" in error_msg:
            print("\n⚠️  PROBLÈME: Authentification échouée")
            print("   • Vérifie FTP_HOST (domaine correct?)")
            print("   • Vérifie FTP_USER (ex: if0_41685322)")
            print("   • Vérifie FTP_PASSWORD (mot de passe correct?)")
        elif "Connection refused" in error_msg:
            print("\n⚠️  PROBLÈME: Impossible de se connecter")
            print("   • Le serveur FTP n'est pas accessible")
            print("   • Vérifie que InfinityFree FTP est activé")
        else:
            print(f"\n⚠️  Erreur: {error_msg}")
        
        return False

def upload_files():
    """Upload files via FTP"""
    try:
        print("\n📤 Début de l'upload...")
        ftp = ftplib.FTP(FTP_HOST, FTP_USER, FTP_PASSWORD, timeout=30)
        ftp.cwd(FTP_REMOTE_PATH)
        
        uploaded = 0
        skipped = 0
        failed = 0
        
        for file in FILES_TO_UPLOAD:
            if not os.path.exists(file):
                print(f"   ⚠️  {file} (fichier manquant, ignoré)")
                skipped += 1
                continue
            
            try:
                print(f"   📤 {file}...", end=" ")
                with open(file, 'rb') as f:
                    ftp.storbinary(f'STOR {file}', f)
                print("✅")
                uploaded += 1
            except Exception as e:
                print(f"❌ ({e})")
                failed += 1
        
        ftp.quit()
        
        # Summary
        print(f"\n📊 Résumé:")
        print(f"   ✅ Upload réussi: {uploaded}")
        print(f"   ⚠️  Ignorés: {skipped}")
        print(f"   ❌ Échoués: {failed}")
        
        if failed > 0:
            print(f"\n❌ {failed} fichier(s) en échec")
            return False
        
        print("\n✅ UPLOAD TERMINÉ!")
        print("🌐 Accès: https://tonsite.infinityfree.net")
        return True
        
    except ftplib.all_errors as e:
        print(f"\n❌ Erreur lors de l'upload: {e}")
        return False

def main():
    """Main function"""
    print("="*50)
    print(" FTP UPLOAD - FINTRACK")
    print("="*50)
    
    # Check credentials
    if "tusite.infinityfree.net" in FTP_HOST or "ton_password" in FTP_PASSWORD:
        print("\n❌ ERREUR: Configure les credentials FTP d'abord!")
        print("\nÉdite ce fichier et remplace:")
        print("  • FTP_HOST = ton domaine InfinityFree")
        print("  • FTP_USER = ton identifiant (if0_XXXXXX)")
        print("  • FTP_PASSWORD = ton mot de passe FTP")
        sys.exit(1)
    
    # Test connection
    if not test_ftp_connection():
        print("\n⚠️  Upload annulé (connexion échouée)")
        sys.exit(1)
    
    # Upload files
    success = upload_files()
    sys.exit(0 if success else 1)

if __name__ == "__main__":
    main()
