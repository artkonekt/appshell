# Admin Panel

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

---

**Next**: [Authentication &raquo;](admin-authentication.md)
