<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Requirements
- [Docker](https://www.docker.com/)

## Running
### Production
```bash
docker compose -f compose.prod.yml up -d
```

### Development
#### First time
```bash
# Enable the custom sail venv
./bin activate
# Start services
sail up -d
# Set permissions to avoid conflicts with the container creating files as root
sudo chown -R $USER:$USER .
# Run the post-create-project-cmd script (creates app key, installs Octane, makes sqlite database and runs migrations)
sail composer run-script post-create-project-cmd
# Restart the services to apply the changes
sail restart
```
#### Subsequent times
```bash
./bin activate
sail up -d # -d is needed to run in the background
```
> NOTE: bin/activate is a custom script that activates the custom sail venv. It is not included in the Laravel Sail package.
> It creates some aliases to avoid typing `./vendor/bin/sail` every time.
> Also common commands like `composer`, `php`, `artisan`, `npm`, `yarn`, `sail` and `sail-root` are sent to the sail container.

## Template routes
| Method    | URI         | Name            | Docs                                    |
|-----------|-------------|-----------------|-----------------------------------------|
| GET\|HEAD | /log-viewer | Log viewer      | https://github.com/opcodesio/log-viewer |
| GET\|HEAD | /pulse      | Pulse dashboard | https://pulse.laravel.com               |

## Troubleshooting
### Laravel pulse migrations not found
For some reason, the migrations for Laravel Pulse are not found when running `php artisan migrate`. To fix this, run the following command to run the Pulse migrations (already done in production environment):
```bash
sail php artisan migrate --path=vendor/laravel/pulse/database/migrations/2023_06_07_000001_create_pulse_tables.php
```

## About Laravel
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel
Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.
You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.
If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors
We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners
- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing
Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct
In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities
If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits
- Laravel Octane Dockerfile: https://github.com/exaco/laravel-octane-dockerfile
- Log viewer: https://github.com/opcodesio/log-viewer
- Laravel Pulse: https://pulse.laravel.com
- Laravel Debug Bar: https://github.com/barryvdh/laravel-debugbar
