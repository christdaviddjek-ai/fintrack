@echo off
REM ════════════════════════════════════════════════════════════════
REM Script d'upload FTP pour Windows (utilise PowerShell)
REM ════════════════════════════════════════════════════════════════

echo.
echo ================================================================
echo   UPLOAD FTP - fintrack vers InfinityFree
echo ================================================================
echo.

REM Configuration
set FTP_HOST=tusite.infinityfree.net
set FTP_USER=if0_41685322
set FTP_PASS=ton_password_ftp
set LOCAL_DIR=C:\wamp64\www\gest_depes
set REMOTE_DIR=/public_html

echo [INFO] Configuration:
echo   Host: %FTP_HOST%
echo   User: %FTP_USER%
echo   Local: %LOCAL_DIR%
echo   Remote: %REMOTE_DIR%
echo.

REM Créer script FTP
echo open %FTP_HOST% > ftp_commands.txt
echo %FTP_USER% >> ftp_commands.txt
echo %FTP_PASS% >> ftp_commands.txt
echo cd %REMOTE_DIR% >> ftp_commands.txt
echo binary >> ftp_commands.txt
echo put "%LOCAL_DIR%\index.html" >> ftp_commands.txt
echo put "%LOCAL_DIR%\inscription.php" >> ftp_commands.txt
echo put "%LOCAL_DIR%\connexion.php" >> ftp_commands.txt
echo put "%LOCAL_DIR%\dashbordd.php" >> ftp_commands.txt
echo put "%LOCAL_DIR%\crud_depense.php" >> ftp_commands.txt
echo put "%LOCAL_DIR%\ajouter.php" >> ftp_commands.txt
echo put "%LOCAL_DIR%\modifier.php" >> ftp_commands.txt
echo put "%LOCAL_DIR%\supprimer.php" >> ftp_commands.txt
echo put "%LOCAL_DIR%\config.php" >> ftp_commands.txt
echo put "%LOCAL_DIR%\security.php" >> ftp_commands.txt
echo put "%LOCAL_DIR%\logout.php" >> ftp_commands.txt
echo put "%LOCAL_DIR%\install.php" >> ftp_commands.txt
echo put "%LOCAL_DIR%\styles.css" >> ftp_commands.txt
echo put "%LOCAL_DIR%\script.js" >> ftp_commands.txt
echo put "%LOCAL_DIR%\.gitignore" >> ftp_commands.txt
echo quit >> ftp_commands.txt

echo [INFO] Exécution upload FTP...
echo.

REM Exécuter FTP
ftp -s:ftp_commands.txt

REM Nettoyer
del ftp_commands.txt

echo.
echo ================================================================
echo   UPLOAD TERMINÉ!
echo ================================================================
echo.
echo [INFO] Accès: https://%FTP_HOST%/index.html
echo.
echo [IMPORTANT] Prochaines étapes:
echo   1. Va sur /install.php pour créer les tables
echo   2. Test signup/login
echo   3. Enjoy! :)
echo.
pause
