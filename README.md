To set up Laravel sure that you have these dependancies installed on your system:
- PHP 8.2+
- Composer 2.2.0


Run these commands in order to run this project:
- git clone https://github.com/Danny-607/quoting-system.git
- cp .env.example .env
- composer install
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- npm run dev
- php artisan serve

Ensure to setup your database correctly within the .env file as well as a mailing system such as mailtrap.io to allow for the mailing functionality of the project to be used.

To run the codeception tests use this command:
php vendor/bin/codecept run --steps

