# Modus Create PHP API Development Assignment

## Interview candidate: João Henrique Abreu from Belo Horizonte,MG,Brasil

This a Laravel application that meets Requirements 1,2 and 3 from Modus Create interview

### php version
The php version used for this assignment was 7.1.9

### Laravel version
5.6 
*Please notice Laravel's apache requirements (https://laravel.com/docs/5.6)

### Instalation instructions
* Run git clone https://github.com/joaohenriqueabreu/modus-create
* Run composer install to install/update all packages
* Copy .env.example file and rename it to .env
* In .env file add the following environment variable: NHTSA_BASE_URL="https://one.nhtsa.gov/webapi/api/SafetyRatings"
* Run php artisan key:generate
* (no need to migrate database)
* Run php artisan serve --port=8080 in order to start the server

### Relevant packages used
GuzzleHttp to make requests for NHTSA api


