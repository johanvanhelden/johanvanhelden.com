# Johan van Helden

Public repository for my website [https://www.johanvanhelden.com](https://www.johanvanhelden.com)

## Setup for local development

### PHP
``` bash
cp .env.example .env
```

Create a database and user as configured in the `.env`

``` bash
composer install
./artisan migrate:fresh --seed
```

##### Authentication for Nova
In order to install the composer dependencies, you need valid Nova credentials.
Place them in your `~/.composer/auth.json` like so:

``` json
"http-basic": {
    "nova.laravel.com": {
        "username": "YOUR_USERNAME",
        "password": "YOUR_PASSWORD"
    }   
}
```

### Assets
``` bash
yarn install
yarn dev
```

Or alternatively you can use the bash script to handle everything:
``` bash
./buildHook.sh $PWD
```

## Testing

### Setup
Create a database and user as configured in the `.env.testing`

### Test

Bootstraps the application and runs the tests against an existing database (`artisan migrate`).

``` bash
composer test
```

### Test fresh

Bootstraps the application, refreshes the database and runs the tests (`artisan migrate:fresh`).

``` bash
composer test-fresh
```

### Test coverage

Generates a test coverage report.

Please install pcov first:

```bash
sudo apt install php-pcov
```

``` bash
composer test-fresh
```

## Security

If you discover any security-related issues, please email [johan@johanvanhelden.com](mailto:johan@johanvanhelden.com) instead of using the issue tracker.

## License

GNU General Public License v3.0 (gpl-3.0). Please see the [License File](LICENSE.md) for more information.

## TODO

### Blog module
- Newsletter module
- Migration, model, factory, seeder, resource
- On home page with detail and pagination
- Nova module
- Publish to twitter
- RSS feed

### Misc
- Translations through Inertia
