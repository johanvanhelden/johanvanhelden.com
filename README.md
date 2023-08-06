# Johan van Helden

Public repository for my website [https://www.johanvanhelden.com](https://www.johanvanhelden.com)

## Setup for local development

### PHP

```bash
cp .env.example .env
```

```bash
composer install
```

### Assets

```bash
npm install
npm run dev
```

Or alternatively you can use the bash script to handle everything:

```bash
./buildHook.sh $PWD
```

## Testing

### Test

Bootstraps the application and runs the tests.

```bash
composer test
```

### Test coverage

Generates a test coverage report.

Please install pcov first:

```bash
sudo apt install php-pcov
```

```bash
composer test
```

## Security

If you discover any security-related issues, please email [johan@johanvanhelden.com](mailto:johan@johanvanhelden.com) instead of using the issue tracker.

## License

GNU General Public License v3.0 (gpl-3.0). Please see the [License File](LICENSE.md) for more information.
