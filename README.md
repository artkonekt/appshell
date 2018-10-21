# Konekt AppShell

[![Travis Build Status](https://img.shields.io/travis/artkonekt/appshell.svg?style=flat-square)](https://travis-ci.org/artkonekt/appshell)
[![Packagist Stable Version](https://img.shields.io/packagist/v/konekt/appshell.svg?style=flat-square&label=stable)](https://packagist.org/packages/konekt/appshell)
[![StyleCI](https://styleci.io/repos/74504388/shield?branch=master)](https://styleci.io/repos/74504388)
[![Packagist downloads](https://img.shields.io/packagist/dt/konekt/appshell.svg?style=flat-square)](https://packagist.org/packages/konekt/appshell)
[![MIT Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)


Konekt AppShell is a Laravel Extension that serves as a foundation for Laravel business applications.
It is also a [Concord box](https://github.com/artkonekt/concord/blob/master/docs/boxes.md).

Incorporates the basics for:

- Users + profiles
- User impersonation
- Authentication, authorization (acl)
- Locations (countries, provinces, addresses)
- Customers
- User settings
- Extensible Admin Interface
- Menu handling

The user/auth part is built on top of the Laravel facilities in a compatible manner.

## Release v1.0 Is On The Corner

To do list for v1.0:

- [ ] Docs (incl. Icon helper usage)
- [ ] Add more provinces to seeders
- [ ] Include `Person` in profile
- [ ] Fix Permissions and Roles page
- [ ] Pimp Customer list table

Scheduled for v1.1:

- [ ] Sortable tree component [vuejs](https://github.com/phphe/vue-draggable-nested-tree)


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

## The User Interface

AppShell comes with an Admin-style UI which you can "plug-in" into your application.

This can be done in two typical ways:

- The application has a single UI, there's no separate Backend/Admin and Public Frontend.
- The application has a separate admin and public area. AppShell UI is being used for admin.

### AppShell As Main App UI

Change the layout in the first line of `resources/views/home.blade.php` file to be:

```blade
@extends('appshell::layouts.default')
```

**Add AppShell assets to Laravel Mix**:

In this scenario, the entire application will be built on top of the AppShell UI,
and the app's and AppShell's javascript files will be combined in a single `app.js` file.

In `webpack.mix.js` change:
```js
// Replace this line:
// mix.js('resources/assets/js/app.js', 'public/js')
// With this one:
mix.js([
    'resources/js/app.js',
    'vendor/konekt/appshell/src/resources/assets/js/appshell.js'
    ], 'public/js/app.js')
   // And replace this line:
   //.sass('resources/assets/sass/app.scss', 'public/css');
   // With this one:
    .sass('vendor/konekt/appshell/src/resources/assets/sass/appshell.sass', 'public/css');
```

Remove the omnipresent Vue instance from Laravel's default app.js file:

`resources/assets/js/app.js`:

```javascript
// REMOVE/COMMENT THESE 3 LINES:
const app = new Vue({
    el: '#app'
});
```

and the compile the assets with mix: `yarn run dev`

### AppShell As Separate Admin UI

This way the default app.js and app.css from Laravel will be intact, and AppShell's assets will
not be mixed with the rest of the application.

**Add AppShell assets to Laravel Mix**:

In `webpack.mix.js` change:
```js
mix.js('resources/js/app.js', 'public/js')
   // Add these 2 lines:
   .js('vendor/konekt/appshell/src/resources/assets/js/appshell.standalone.js', 'public/js/appshell.js')
   .sass('vendor/konekt/appshell/src/resources/assets/sass/appshell.sass', 'public/css')
   // Keep this for the "rest" (usually public frontend)
   .sass('resources/sass/app.scss', 'public/css');
```

and the compile the assets with mix: `yarn run dev`

> **TIP:** You may need to [install yarn](https://yarnpkg.com/en/docs/install)
> and run:
```bash
yarn install
```


## Built-in Facilities

### Menu

The menu functionality is built on top of [Konekt Menu Component](https://github.com/artkonekt/menu). The component is automatically loaded, is fully available (incl. the `Menu` facade).

AppShell creates a menu named **appshell** which is the main menu component, and is available in views as `$appshellMenu`.

## Upgrading

### 0.9 -> 1.0

