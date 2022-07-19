Steps to run locally:

~!~ MAKE SURE YOU HAVE PHP && COMPOSTER ON YOUR PC ~!~


-   Download api zip file
-   unzip it and open in vscode
-   npm i
-   Create a mysql database with xampp locally named onlineShop -> utf8_general_ci
-   Rename '.env.example' file to '.env' inside the project root, delete it all and then fill it as follow: (very important to copy it as is!)

-   Open the console and cd your project root directory
-   Run: //composer install// or: //php composer.phar install//
-   Run: //php artisan key:generate//
-   Run: //php artisan migrate//
-   Run: //php artisan serve//

\\You can now access the project at localhost:8000\\

\\make sure that sql is active as the data will be saved in a sql DB\\

! Make sure api is listening on port 8000 !
After BOTH api and client are up and running go to localhost:4200 to start using the app
