# Johan van Helden

Public repository for my website [https://www.johanvanhelden.com](https://www.johanvanhelden.com)

## Requirements

Before you begin, ensure you have the following installed:

-   PHP 8.3
-   Composer 2
-   NVM with Node 22
-   MySQL 5.7

## Setting up the Application

### Production

Follow these steps to set up the application for production:

1. Copy the `.env.example` to `.env`.
2. Install dependencies by running `composer install --no-dev`.
3. Set up a new key for the application with `artisan key:generate`.
4. Update the `.env` file with the correct app and other configurations.
5. Create a symbolic link for storage with `artisan storage:link`.
6. Build assets with `make assets`.

### Development

Follow these steps to set up the application for development:

1. Ensure Dockerhero is running
2. Ensure the `dockerhero-nginx` repository is cloned locally, in the same folder where this project is cloned (e.g., `~/projects/`).
3. Create a database and then choose one of the following options:
    1. Ensure the database is set up with the credentials that are in the `.env.example`
    2. Copy the the `.env.example` to `.env`
4. Run `make init`

## Testing

### Test

Bootstraps the application and runs the tests.

```sh
make test
```

### Test coverage

Generates a test coverage report.

Please install pcov first:

```sh
sudo apt install php-pcov
```

```sh
make test-coverage
```

## Security

If you discover any security-related issues, please email [johan@johanvanhelden.com](mailto:johan@johanvanhelden.com) instead of using the issue tracker.

## License

GNU General Public License v3.0 (gpl-3.0). Please see the [License File](LICENSE.md) for more information.
