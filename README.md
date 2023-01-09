# LARAVEL 8 E-COMMERCE

---

[Laravel PHP Framework 8.0](http://laravel.com).
.
## Prerequisites

1. PHP > 7.3
1. MySQL or PostgreSql
1. [Composer](http://getcomposer.org)


## Getting Started

1. Clone to your base project directory.
    
	```
	git clone https://github.com/rizalsk/laravel8-ecommerce.git laravel-ecommerce
	```
	
2. Go to project dir.
    
	```
	cd laravel-ecommerce
	```
	
3. Install composer dependencies.

	```
	composer install
	```
	
4. Create configuration file `.env` (copy from `.env.example`)

	```
	##MySQL
	DB_CONNECTION=mysql
	DB_HOST=localhost
	DB_PORT=3306
	DB_DATABASE=database_name
	DB_USERNAME=root
	DB_PASSWORD=
	```
    
5. Migrate the database.

	```
	php artisan migrate
	```
6. Seed the user database.

	```
	php artisan db:seed
	```
7. Run Artisan command Install Passport Oauth2.

	```
	php artisan run serve --port=8000
	
	```

8. Login with admin
    - Default URL : 127.0.0.1:8000/admin/login
    - params
        ```
        email : admin@mail.com
        password : password
        ```
        

## Plugins
In this laravel 8.0, **we've installed**:

1. [Jetstream](https://jetstream.laravel.com/2.x/introduction.html)
