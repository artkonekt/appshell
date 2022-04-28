# Installation

> For upgrading from an earlier AppShell versions refer to the [Upgrade](upgrade.md) section.

## Requirements

As of AppShell v3.0 (unreleased), the requirements are:

- PHP 8.0 or PHP 8.1
- Laravel 8.12+

## Install AppShell

Either create a new Laravel project:

```bash
composer create-project laravel/laravel myapp
cd myapp
```

.. or go to an existing Laravel 6+ application's root folder and launch these commands:

```bash
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

> If you have multiple Concord modules, AppShell typically needs to be the very first one in the list.

Test if it works by invoking the command:

```bash
php artisan concord:modules
```

Now you should see this:

```
+----+---------------------+------+---------+------------------+-----------------+
| #  | Name                | Kind | Version | Id               | Namespace       |
+----+---------------------+------+---------+------------------+-----------------+
| 1. | Konekt AppShell Box | Box  | 3.0-dev | konekt.app_shell | Konekt\AppShell |
+----+---------------------+------+---------+------------------+-----------------+
```

> **TIP:** Try `php artisan concord:modules -a` to see ALL modules

Configure `.env`, along with a database.

Afterwards run the migrations:

```bash
php artisan migrate
```

AppShell (with the underlying modules) contains ~20 migrations out of the box.

## Laravel Auth Support

### Auth Scaffolding

> Laravel, with the release of version 6 has significantly changed the way of auth scaffolding.
> For details, refer to [Laravel Authentication Docs](https://laravel.com/docs/6.x/authentication#authentication-quickstart).

If you haven't done it yet, install the Laravel UI package:

```bash
composer require laravel/ui
php artisan ui:auth
```

### The User Model

AppShell offers a pre-built `User` model, that is an extended version of the default Laravel User
class. It's not mandatory to use this class though, it's possible to use your own models instead.

To complete user setup, you have several options, see some of the variants below.

#### Variant 1 - Simple

Modify `App\User` so that it extends AppShell's user model:

```php
// app/User.php
namespace App;

// No need to use Laravel default traits and properties as
// they're already present in the base class exactly as
// they're defined in a default Laravel installation
class User extends \Konekt\AppShell\Models\User
{
}
```

Add this to your `AppServiceProviders`'s boot method:

```php
   $this->app->concord->registerModel(\Konekt\User\Contracts\User::class, \App\User::class);
```

#### Variant 2 - Flexible

In case you don't want to extend AppShell's User class, then it's sufficient to implement its
interface:

```php
// app/User.php
// ... The default User model or arbitrary code for your app

// You can use any other base class eg: TCG\Voyager\Models\User
use Illuminate\Foundation\Auth\User as Authenticatable;
use Konekt\User\Contracts\Profile;
use Konekt\User\Contracts\User as UserContract;

class User extends Authenticatable implements UserContract
{
    // ...

    // Implement these methods from the required Interface:
    public function inactivate()
    {
        $this->is_active = false;
        $this->save();
    }

    public function activate()
    {
        $this->is_active = true;
        $this->save();
    }

    public function getProfile(): ?Profile
    {
        return null;
    }

    // ...
}
```

Add this to your `AppServiceProviders`'s boot method:

```php
   $this->app->concord->registerModel(\Konekt\User\Contracts\User::class, \App\User::class);
```

#### Variant 3 - No App\User

If the "final" user class is not going to be `App\User` then don't forget to modify model the
configuration in your app's `config/auth.php` file:

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

### Create An Initial Super User

Run command `php artisan make:superuser`.

This will ask a several questions and create a proper superuser that you can start working with.

### Frontend Installation

Since this package will be built along with your application, it's assets need to be added to it:

**1. Add Admin's CSS To Laravel Mix:**

```javascript
   // webpack.mix.js
   mix.js('resources/js/app.js', 'public/js')
    // Add these 2 lines:
   .js('vendor/konekt/appshell/src/resources/assets/js/appshell.standalone.js', 'public/js/appshell.js')
   .sass('vendor/konekt/appshell/src/resources/assets/sass/appshell.sass', 'public/css')
    // Keep the the original assets if needed or remove them if AppShell's UI is the only one of your app
```

**2. Install the following npm packages:**

```bash
npm add bootstrap@4.6 jquery alpinejs@3.10 popper.js
```

**3. Compile the assets with mix:** `npm run dev`


---

**Next**: [Application Prerequisites &raquo;](configuration.md)
