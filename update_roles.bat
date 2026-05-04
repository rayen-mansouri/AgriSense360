@echo off
php bin/console doctrine:query:sql "UPDATE user SET roles = '[\"ROLE_ADMIN\"]' WHERE email = 'ahmedhabouba@gmail.com'"
php bin/console doctrine:query:sql "UPDATE user SET roles = '[\"ROLE_GERANT\"]' WHERE email = 'ahmedhabouba.com@gmail.com'"
php bin/console doctrine:query:sql "UPDATE user SET roles = '[\"ROLE_OUVRIER\"]' WHERE email = 'kiko@gmail.com'"
php bin/console doctrine:query:sql "UPDATE user SET roles = '[\"ROLE_OWNER\"]' WHERE email = 'aa@mail.com'"