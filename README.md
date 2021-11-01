#SymfCRUD
Hello, It's Dawid, to try my app you need to add your own values to database params in .env file:
DB_USER=

DB_PASSWORD=

DB_HOST=

DB_PORT=

DB_NAME=

next run in your project folder comands:

php bin/console doctrine:database:create

php bin/console doctrine:migrations:diff

php bin/console doctrine:migrations:migrate

After that you just need to start the server in /public folder

For Example:

php -S localhost:3000

The Rest is to try it :) Enjoy !
