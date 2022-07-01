 
## About Laravel Setup Setup
1. Run composer command `composer install`
2. Install create  `.env` file and Add Database Connection Details
3. Migrate Database using `php artisan migrate` command
4. Key Generate `php artisan key:generat`
5. Run Project Using `php artisan serve`
6. Jwt secreate token generate `php artisan jwt:secret`

## Additional command
1. For Recreate Database structure `php artisan migrate:refresh
`

    More Info:- <a href="https://laravel.com/docs/9.x/migrations#roll-back-migrate-using-a-single-command" target="_blank">https://laravel.com/docs/9.x/migrations#roll-back-migrate-using-a-single-command</a>
1. For Drop all Database table structure `php artisan migrate:fresh
`


## For Auto Generate API Document

1. First, add the package via Composer: `composer require --dev knuckleswtf/scribe`
2. Publish the config file by running:  `php artisan vendor:publish --tag=scribe-config`.

    This will create a `scribe.php` file in your `config` folder.
3. After install run command `php artisan scribe:generate`
4. After Run Project Get API Document `http://127.0.0.1:8000/docs`
    For More Info:- <a href="https://scribe.knuckles.wtf/laravel/" target="_blank">https://scribe.knuckles.wtf/laravel/</a>


## For Create Database Table
1. For Create Blank Table `php artisan make:migration create_YOURETABLE_NAME_table`

    For More Info:- <a href="https://laravel.com/docs/9.x/migrations" target="_blank">https://laravel.com/docs/9.x/migrations</a>


Notes:-  Database Table column Types <a href="https://laravel.com/docs/9.x/migrations#available-column-types" target="_blank" >https://laravel.com/docs/9.x/migrations#available-column-types</a>