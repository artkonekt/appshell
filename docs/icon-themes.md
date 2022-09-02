# Icon Themes

To be written.

- `trait ExtendsIconThemes`

```php
icon('star', null, ['animate' => true]);
// Font Awesome only:
icon('star', null, ['animate' => 'beat']);
```

### Font Awesome 6 Pro Support

In order to utilize the Pro icons of Font Awesome, apart from choosing the Icon Theme in settings,
you need to supply the following configuration variables:

```php
// config/concord.php
return [
    'modules' => [
        Konekt\AppShell\Providers\ModuleServiceProvider::class => [
            'icons' => [
                'fa6_pro' => [
                     // Your own Pro kit code, copied from the Font Awesome website:
                    'kit_code' => '<script src="https://kit.fontawesome.com/f2a94220aa.js" crossorigin="anonymous"></script>',
                    'icon_style' => 'regular', // one of: solid, regular, light, thin, duotone
                ]            
            ],
        ],
    ],
];
```

---

**Next**: [Add Assets To The Layout &raquo;](assets.md)
