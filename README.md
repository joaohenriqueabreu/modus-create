# Modus Create PHP API Development Assignment

## Interview candidate: João Henrique Abreu from Belo Horizonte,MG,Brasil

This a Laravel application that meets Requirements 1,2 and 3 from Modus Create interview

As it is in Laravel it is recommended to use 'php artisan serve' to run in standard localhost:8000. If you wish to run in a different port 
follow instructions on https://laravel.com/docs/5.6

### Laravel version
5.6
*Please notice Laravel's apache requirements (https://laravel.com/docs/5.6)

### Instalation instructions
git clone https://github.com/joaohenriqueabreu/modus-create
run composer update to install/update all packages
In .env file add the following environment variable: NHTSA_BASE_URL="https://one.nhtsa.gov/webapi/api/SafetyRatings"

### Relevant packages used
GuzzleHttp to make requests for NHTSA api

