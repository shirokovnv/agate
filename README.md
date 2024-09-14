# Agate

![ci.yml][link-ci]

API Gateway written with [PHP][link-php] and [Laravel Framework][link-laravel].

Uses [PostgreSQL][link-postgresql] as a database.

Can be used as a proxy between external client and microservice circuit 
by collecting data and aggregating results.

# Project setup

## Requirements

- [Docker][link-docker] v24.x
- [Make][link-make] v4.x

### For the first time only
- `git clone https://github.com/shirokovnv/agate.git`
- `cd agate`
- `make setup`

### From the second time onwards
- `make up`

# Notes

### Main App

http://localhost

### JSON SCHEMA INTROSPECTION

http://localhost/api/internal/v1/schema/actions

http://localhost/api/internal/v1/schema/services

_See database seeds for understanding the schema and example usage._

## License

MIT. Please see the [license file](LICENSE.md) for more information.

[link-php]: https://www.php.net/
[link-laravel]: https://laravel.com
[link-postgresql]: https://www.postgresql.org/
[link-ci]: https://github.com/shirokovnv/agate/actions/workflows/ci.yml/badge.svg
[link-docker]: https://www.docker.com/
[link-make]: https://www.gnu.org/software/make/manual/make.html
