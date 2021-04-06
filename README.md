# Anikura Server

Anikura is a multimedia server written in PHP, using the [Symfony](https://symfony.com/) framework.

## Requirements

- PHP 8
- Composer
- Node.js
- Yarn
- PostgreSQL (database)

## Installation

**TODO: add Docker installation guide**

### Manual installation

1. **TODO: add requirements check**

2. Install dependencies with Composer

```bash
# for development
composer install

# for deployment
composer install --no-dev --optimize-autoloader
```

3. Create a .env.local file and edit it to your needs.
(It won't be commited to any git repository.)

(**IMPORTANT**: if you're deploying the app,
you *MUST* set `APP_ENV` to `prod` and edit `APP_SECRET`.)

```bash
cp .env .env.local
```

4. Create a database and migrate tables.

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

You can also load sample data fixtures when developing:

```bash
php bin/console doctrine:fixtures:load
```

5. Install Node.js dependencies with Yarn:

```bash
yarn
```

6. Build the front-end bundle with Encore
(if you don't plan on modifying JS, CSS etc,
then you will need to perform this only once) 

```bash
# for development
yarn dev

# for deployment
yarn build
```

Watching for changes is also possible:

```bash
yarn watch
```

7. Serve the `public` catalog

```bash
# for development
php -S localhost:8000 -t public

# for deployment, you will want to use Apache, nginx, Caddy etc
```

And that's it! Now you can use Anikura.

**TODO: actually not - add admin user creation**
