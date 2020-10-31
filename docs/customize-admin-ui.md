# Customizing The Admin UI

> The customization has fundamentally changed with v2.0. If you're still on AppShell v1, refer to
> the [customization section in v1.8 docs](https://konekt.dev/appshell/1.8/customize-admin-ui)

The user interface was built on top of [Bootstrap 4.x](https://getbootstrap.com/docs/4.5).

The SASS files can be found in the `src/resources/assets/sass/` folder, and the javascript files are
in the `src/resources/assets/js/` folder (under `vendor/konekt/appshell`).

## Customizing The Existing CSS

> Read the [Laravel Mix](https://laravel.com/docs/8.x/mix#sass) Documentation for more details about
> managing frontend assets in your application.

In case you want use the default AppShell stylesheet, and add moderate customizations to it,
you can modify the build script in your application (mostly webpack + laravel mix).

Copy all the sass files from the
`vendor/konekt/appshell/src/resources/assets/sass/` folder to your application's
`resources/assets/sass/` folder and modify them freely.

**Example:**

```js
// webpack.mix.js
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/appshell.sass', 'public/css'); // <- add appshell to mix config
```

## Custom Theme

If you want to have a completely custom layout/theme, then the best is to define a new theme instead
of tweaking the built-in AppShell theme.

---

**Next**: [Themes &raquo;](themes.md)
