## Instructions
Clone the repository: git clone https://github.com/aliou2250/laravel_project
Install dependencies: composer install
Copy the .env.example file to .env and configure the database settings
Generate an application key: php artisan key:generate
Run database migrations: php artisan migrate
Seed the database: php artisan db:seed

## Mail sending management
in the .env file modify the line MAIL_HOST=mailpit to MAIL_HOST=localhost (for the local test) and you will need an external service for the reception of mail locally which is [MAILHOG](https://github.com/mailhog/MailHog)

## Daily mail
create a daily task that sends email alerts to users about tasks that are due: php artisan app:send-due-task-notifications

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
