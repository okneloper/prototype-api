# Installation

## Install dependencies 
Docker is required to run the app. The application was tsted on 
[Laravel Sail](https://laravel.com/docs/9.x/sail).  

NB. Laravel Sail is supported on macOS, Linux, and Windows (via WSL2).

Cd into the project directory and run the following command to 
install the dependencies using a PHP8.1 docker container. PHP8.1 is the version 
the app will run on.

```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

I've included the `.env` file (which is usually excluded from git) so that the app
can be run wihtout any configuration.

## Start the app
Start the docker environment
```shell
./vendor/bin/sail up -d
```

Run database migrations
```shell
./vendor/bin/sail artisan migrate --seed
```

The app is now accessible at http://localhost/

# Running tests

```shell
./vendor/bin/sail test
```

# Application structure
This is a laravel (latest version) application. 

The repository includes some default data: 3 kinds of users and their access tokens.
This is defined in `database/seeders/DatabaseSeeder.php`.

User authentication is handled by [Laravel Sanctum](https://laravel.com/docs/9.x/sanctum). 
The token _abilities_ are defined in the seeder above. The mapping to routes is defined
in the API routes file: `routes/api.php`

Controllers can be found in `app/Http/Controllers`.

Tests reside in `tests/Feature`. 

`Eleving API.postman_collection.json` is a Postman collection (v2.1) of 
some sample requests.
