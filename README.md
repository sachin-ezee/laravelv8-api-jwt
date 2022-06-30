 
## About Laravel Setup Setup
1. Run composer command `composer install`
2. Install create  `.env` file and Add Database Connection Details
3. Migrate Database using `php artisan migrate` command
4. Key Generate `php artisan key:generat`
5. Run Project Using `php artisan serve`
6. Jwt secreate token generate `php artisan jwt:secret`

## For Auto Generate API Document

1. First, add the package via Composer: `composer require --dev knuckleswtf/scribe`
2. Publish the config file by running:  `php artisan vendor:publish --tag=scribe-config`.

    This will create a `scribe.php` file in your `config` folder.
3. After install run command `php artisan scribe:generate`

    For More Info:- <a href="https://scribe.knuckles.wtf/laravel/" target="_blank">https://scribe.knuckles.wtf/laravel/</a>
