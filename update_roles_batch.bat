@echo off
setlocal
cd /d "C:\Users\iamam\OneDrive\Bureau\AgriSense360"

REM Create a SQL script file
(
echo UPDATE user SET roles = JSON_ARRAY('ROLE_ADMIN') WHERE email = 'ahmedhabouba@gmail.com';
echo UPDATE user SET roles = JSON_ARRAY('ROLE_GERANT') WHERE email = 'ahmedhabouba.com@gmail.com';
echo UPDATE user SET roles = JSON_ARRAY('ROLE_OUVRIER') WHERE email = 'kiko@gmail.com';
echo UPDATE user SET roles = JSON_ARRAY('ROLE_OWNER') WHERE email = 'aa@mail.com';
echo SELECT email, roles FROM user WHERE email IN ('ahmedhabouba@gmail.com', 'ahmedhabouba.com@gmail.com', 'kiko@gmail.com', 'aa@mail.com');
) > update_roles.sql

REM Run MySQL
"C:\xampp\mysql\bin\mysql.exe" --protocol=TCP -h 127.0.0.1 -P 3306 -u root -pPassword123 agrisense360 < update_roles.sql

REM Clean up
del update_roles.sql
echo Done!
