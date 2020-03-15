# Installation

> For upgrading from an earlier AppShell versions refer to the [Upgrade](upgrade.md) section.

## Create New AppShell Project

```bash
composer create-project laravel/laravel myapp
# Wait 1-4 minutes to complete ...
cd myapp
composer require konekt/appshell
touch config/concord.php
```

Edit `config/concord.php` and add this content to it:

```php
<?php

return [
    'modules' => [
        Konekt\AppShell\Providers\ModuleServiceProvider::class
    ]
];
```

### Register The Service Provider (Laravel 5.4 Only)

Edit `config/app.php` and add this line to the `providers` array (below 'Package Service Providers', always above 'Application Service Providers')

(_Recommended line: just below tinker's service provider_)

```php
Konekt\Concord\ConcordServiceProvider::class,
```

Test if it works by invoking the command

```bash
php artisan concord:modules
```

Now you should see this:

```
+----+---------------------+------+---------+------------------+-----------------+
| #  | Name                | Kind | Version | Id               | Namespace       |
+----+---------------------+------+---------+------------------+-----------------+
| 1. | Konekt AppShell Box | Box  | 0.9.10  | konekt.app_shell | Konekt\AppShell |
+----+---------------------+------+---------+------------------+-----------------+
```

> **TIP:** Try `php artisan concord:modules -a` to see ALL modules

Configure `.env`, along with a database.

Afterwards run the migrations:

```bash
php artisan migrate
```

AppShell contains ~10-15 migrations out of the box

> If running with linux + apache/nginx these commands are useful:
>
> `sudo chown -R .www-data storage/`
>
> `sudo chmod -R g+w storage/`

## Laravel Auth Support

First, Run `php artisan make:auth`

If the "final" user class is not going to be `App\User` then don't forget to modify model class this to your app's `config/auth.php` file:
```php
    //...
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            // 'model' => App\User::class <- change this to:
            'model' => Konekt\AppShell\Models\User::class,
        ],
    //...
```
**OR:**
Another approach is to keep `App\User` but modify the class to extend AppShell's user model:

```php
namespace App;

// No need to use Laravel default traits and properties as
// they're already present in the base class

class User extends \Konekt\AppShell\Models\User {}
```

And add this to you `AppServiceProviders`'s boot method:

```php
   $this->app->concord->registerModel(\Konekt\User\Contracts\User::class, \App\User::class);
```

### Create An Initial Super User

Run command `php artisan appshell:super`.

This will ask a several questions and create a proper superuser that you can start working with.

---

**Next**: [Application Prerequisites &raquo;](prerequisites.md)
