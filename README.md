Steps to run locally:

~!~ MAKE SURE YOU HAVE PHP && COMPOSTER ON YOUR PC ~!~


-   Download api zip file
-   unzip it and open in vscode
-   npm i
-   Create a mysql database with xampp locally named onlineShop -> utf8_general_ci
-   Rename '.env.example' file to '.env' inside the project root, delete it all and then fill it as follow: (very important to copy it as is!)


APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:0oQixKHlqN0JdcJ213zW9SWnUbrdnQ1HI6wSR4VFgzk=
APP_DEBUG=true
APP_URL=http://localhost
APP_URL_CLIENT=http://localhost:4200

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=onlineshop
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=shopmanagermail@gmail.com
MAIL_PASSWORD=gcsnuvvgoxxzkudw
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=shopmanagermail@gmail.com
MAIL_FROM_NAME="Shop Manager"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"


-   Open the console and cd your project root directory
-   Run: //composer install// or: //php composer.phar install//
-   Run: //php artisan key:generate//
-   Run: //php artisan migrate//
-   Run: //php artisan serve//

\\You can now access the project at localhost:8000\\

\\make sure that sql is active as the data will be saved in a sql DB\\

! Make sure api is listening on port 8000 !
After BOTH api and client are up and running go to localhost:4200 to start using the app
