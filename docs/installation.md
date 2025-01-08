# Installation

> For upgrading from an earlier AppShell versions refer to the [Upgrade](upgrade.md) section.

## Requirements

As of AppShell v4.0, the requirements are:

- PHP 8.2 - 8.3
- Laravel 10.x, 11.x

## Install AppShell

Either create a new Laravel project or go to an existing Laravel 10+ application's root folder and launch these commands:

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
+----+---------------------+------+----------+------------------+-----------------+
| #  | Name                | Kind | Version  | Id               | Namespace       |
+----+---------------------+------+----------+------------------+-----------------+
| 1. | Konekt AppShell Box | Box  | 4.6.0    | konekt.app_shell | Konekt\AppShell |
+----+---------------------+------+----------+------------------+-----------------+
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

Depending on your needs, Laravel offers you several starter kits for authentication: https://laravel.com/docs/11.x/starter-kits

As a reference, here we're showing you how to install breeze with blade, but you can choose any other solution you like.

```bash
composer require laravel/breeze --dev

php artisan breeze:install
```

### The User Model

AppShell offers a pre-built `User` model, that is an extended version of the default Laravel User
class. It's not mandatory to use this class though, it's possible to use your own models instead.

To complete user setup, you have several options, see some of the variants below.

#### Variant 1 - Simple

Modify `App\Models\User` class that comes with the default Laravel installation so that it extends AppShell's user model:

```php
// app/Models/User.php
namespace App\Models;

// No need to use Laravel default traits and properties as
// they're already present in the base class exactly as
// they're defined in a default Laravel installation
class User extends \Konekt\AppShell\Models\User
{
}
```

Add this to your `AppServiceProviders`'s boot method:

```php
   $this->app->concord->registerModel(\Konekt\User\Contracts\User::class, \App\Models\User::class);
```

#### Variant 2 - Flexible

In case you don't want to extend AppShell's User class, then it's sufficient to implement its
interface:

```php
// app/Models/User.php
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
   $this->app->concord->registerModel(\Konekt\User\Contracts\User::class, \App\Models\User::class);
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

## Frontend Installation

Regardless of the build tool (vite, webpack, etc) you'll need the following packages for AppShell:

```bash
npm add bootstrap@5.3 alpinejs@3.14 popper.js
```

In the next step, choose your preferred build tool.

### Vite

If your application uses Vite to build the frontend, see the sample config file below.
The example keeps the public frontend and the AppShell frontend separated, but feel free to modify according to your needs.

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'vendor/konekt/appshell/src/resources/assets/js/appshell.standalone.js',
                'resources/css/app.css',
                'vendor/konekt/appshell/src/resources/assets/sass/appshell.sass',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        },
    },
    build: {
        outDir: 'public',
        rollupOptions: {
            input: {
                appJs: 'resources/js/app.js',
                appshellJs: 'vendor/konekt/appshell/src/resources/assets/js/appshell.standalone.js',
                appStyles: 'resources/css/app.css',
                appshellStyles: 'vendor/konekt/appshell/src/resources/assets/sass/appshell.sass',
            },
            output: {
                entryFileNames: ({ name }) => {
                    if (name === 'appshellJs') {
                        return 'js/appshell.js';
                    }
                    if (name === 'appJs') {
                        return 'js/app.js'
                    }
                    return 'js/[name].js';
                },
                chunkFileNames: 'js/[name].js',
                assetFileNames: ({ name }) => {
                    if (/^appStyles\.css$/.test(name ?? '')) {
                        return 'css/app.css';
                    }
                    if (/^appshellStyles\.css$/.test(name ?? '')) {
                        return 'css/appshell.css';
                    }
                    if (/\.css$/.test(name ?? '')) {
                        return 'css/[name].[ext]';
                    }
                    return 'assets/[name].[ext]';
                },
            },
        },
        emptyOutDir: false,
    },
});
```

### Laravel Mix

You can still use Laravel Mix if you prefer it over Vite.

Add the AppShell assets to the mix config:

Add Admin's CSS To Laravel Mix:

```javascript
   // webpack.mix.js
   mix.js('resources/js/app.js', 'public/js')
    // Add these 2 lines:
   .js('vendor/konekt/appshell/src/resources/assets/js/appshell.standalone.js', 'public/js/appshell.js')
   .sass('vendor/konekt/appshell/src/resources/assets/sass/appshell.sass', 'public/css')
    // Keep the the original assets if needed or remove them if AppShell's UI is the only one of your app
```

### Compilation

Add the SASS compiler:

```bash
npm add -D sass
```
Now you can compile the assets:

```bash
npm run build
```

Once these steps succeed, you can start a local server with `php artisan serve` and open the default AppShell interface at:
http://127.0.0.1:8000/admin/user


---

**Next**: [Application Prerequisites &raquo;](configuration.md)
