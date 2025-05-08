@echo off
REM Spostati nella cartella giusta
cd /d "apache\Apache24\bin"

REM Avvia Apache in una nuova finestra del terminale
start "Apache Server" cmd /k "httpd.exe"

REM Aspetta qualche secondo per dare il tempo ad Apache di partire
timeout /t 5 /nobreak

REM Avvia PaperCut
start "" "%LocalAppData%\PapercutSMTP\current\Papercut.exe"

REM Ancora una piccola attesa (opzionale)
timeout /t 3 /nobreak

REM Apre il browser
start "" "http://localhost/pagine/index.php"

exit
