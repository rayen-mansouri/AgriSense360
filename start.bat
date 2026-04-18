@echo off
setlocal

cd /d "%~dp0"

start "PHP Server" cmd /k "cd /d %~dp0 && php -S localhost:8000 -t public"
start "Uvicorn API" cmd /k "cd /d %~dp0src\main\python && uvicorn api:app --host 127.0.0.1 --port 8001 --reload"

endlocal