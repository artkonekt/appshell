# Admin Panel

## The User Interface

AppShell comes with an Admin-style UI which you can "plug-in" into your application.

This can be done in two typical ways:

- The application has a single UI, there's no separate Backend/Admin and Public Frontend.
- The application has a separate admin and public area. AppShell UI is being used for admin.

### AppShell As Main App UI

Change the layout in the first line of `resources/views/home.blade.php` file to be:

```blade
@extends('appshell::layouts.private')
```

This layout will dynamically extend the chosen theme under the hood.

**Add AppShell assets to Laravel Mix**:

In this scenario, the entire application will be built on top of the AppShell UI,
and the app's and AppShell's javascript files will be combined in a single `appshell3.js` file.

In `webpack.mix.js` change:
```js
// Replace this line:
// mix.js('resources/assets/js/app.js', 'public/js')
// With this one:
mix.js([
    'resources/js/app.js',
    'vendor/konekt/appshell/src/resources/assets/js/appshell3.js'
    ], 'public/js/appshell3.js')
   // And replace this line:
   //.sass('resources/assets/sass/app.scss', 'public/css');
   // With this one:
    .sass('vendor/konekt/appshell/src/resources/assets/sass/appshell3.sass', 'public/css');
```

> You can use any name for the output js file instead of `appshell3.js`, eg. `app.js`.
> To do so change the second mix.js parameter from `'public/js/appshell3.js'` to the desired name,
> and change in your app's `config/concord.php` the JS filename according to
> [Customizing Admin UI Documentation](customize-admin-ui.md).

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
   .js('vendor/konekt/appshell/src/resources/assets/js/appshell.standalone.js', 'public/js/appshell3.js')
   .sass('vendor/konekt/appshell/src/resources/assets/sass/appshell3.sass', 'public/css')
   // Keep this for the "rest" (usually public frontend)
   .sass('resources/sass/app.scss', 'public/css');
```

and the compile the assets with mix: `yarn run dev`

> **TIP:** You may need to [install yarn](https://yarnpkg.com/en/docs/install)
> and run:
```bash
yarn install
```

## Private And Public Layouts

Regardless of whether you use AppShell as a Single UI or a separate Admin UI with some public
frontend, it has two layouts:

- `appshell::layouts.private`
- `appshell::layouts.public`

The private layout is the one that is available after user login, containing menus, account dropdown
and other elements depending on the logged in users' [access level](acl.md).

The public layout is for views that are accessible for unauthenticated users. These are the login,
register and forgot password pages by default. Your application may expose additional public pages,
like a public status page or public reports. The views of those pages should extend the public
layout:

```blade
@extends('appshell::layouts.public')
```

## Use Mix Asset Function

> Feature added in v2.4

The default AppShell theme uses the `asset()` function to inject css and js files into the layout by default.

In case you want to use `mix()` instead of asset, set the `konekt.app_shell.ui.use_mix` config value to true.

The easiest way to set configuration values is to pass them directly in `config/concord.php`:

```php
return [
    'modules' => [
        Konekt\AppShell\Providers\ModuleServiceProvider::class => [
            'ui' => [
                'use_mix' => true,
            ]            
        ]
    ]
];
```

---

**Next**: [Authentication &raquo;](admin-authentication.md)
