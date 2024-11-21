# AppShell Changelog

## Unreleased
##### 2024-XX-YY

- Added CRUD for Countries and Provinces
- Added the `globe` icon

## 4.3.0
##### 2024-10-29

- Added the possibility to extend/override "for" definitions in requests with the `HasFor` trait

## 4.2.0
##### 2024-10-29

- Added missing support to pass a callback as the badge widget's `text` option

## 4.1.0
##### 2024-09-16

- Upgraded the Tabler Icon Theme to use the v3.x assets from the CDN (from 1.x)

## 4.0.1
##### 2024-07-29

- Fixed the invalid Eloquent Sluggable package version requirement

## 4.0.0
##### 2024-07-04

- BC: Added the `supportedIcons()` static method to the `IconTheme` interface
- BC: Upgrade to Bootstrap 5.3
- BC: Renamed the `group` widget/component to `card`
- BC: Upgrade to Konekt Acl v2
- Added Laravel 11 support
- Added Components based on the Laravel Blade Components Feature
- Added `page-actions` blade stack that themes need to define
- Added colored enum icon feature via the `color_enum_icon()` helper
- Added feature to specify the color of text widgets
- Added `hover` option to table widget (adds `table-hover` if enabled)
- Added the `hideIf` directive to table columns (widget)
- Added the `rowAttributes` option to the table widget
- Added the `searchable()` method to the `Filter` interface
- Added the `HasControllerHooks` trait to the base controller class
- Added the Trident Theme - it has been written from scratch with new visual style
- Added the Lucide Icon Theme (see https://lucide.dev)
- Added the following blade components:
  - Alert
  - Badge
  - Floating Label
  - CancelButton, SaveButton, CreateAction, StandardActions
- Added custom `tag` support for card component
- Added the following icons: `upload`, `download`, `comment`
- Added the feature to substitute array values and/or object properties of any depth in widgets
- Added the feature to use closures in widget color definitions
- Added support for using closures as widget text prefix and suffix
- Added the `text_if_null` widget modifier
- Added the image widget
- Added the `enum_color` feature to the widget color options
- Added the following icons: folder, file
- Added the `Currencies` helper class and the `CurrencyExists` validation rule
- Added the konekt/xtend package dependency
- Fixed settings/preferences TreeBuilder related issues with premature loading, and possible stale/corrupt data in Octane environment
- Dropped Laravel 9 support
- Dropped Enum v3 support
- Dropped PHP 8.1 support & added PHP 8.3 support
- Replaced all bcrypt calls with `Hash::make()`
- Replaced the multiselect dropdown with a nice-select2 implementation
- Replaced the abandoned laravelcollective/html package with the konekt/html fork for Laravel 11 compatibility
- Changed minimum version requirements:
  - Enum v4.1
  - Address v3.0
  - Gears v1.12
  - Concord v1.15
- Changed Breadcrumbs dependency from v7 to v8
- Changed `bcrypt()` to `Hash::make()` in the make:superuser command
- Changed the filename of `resources/database/currencies.json` (removed the leading space from the filename)

## 3.10.0
##### 2023-12-17

- Added PHP 8.3 support
- Added the `supportedIcons()` method to all icon themes (the method is a v4 `IconTheme` interface method candidate)

## 3.9.0
##### 2023-03-10

- Added enum color support via `EnumColors` registry class and `enum_color()` helper function

## 3.8.0
##### 2023-03-05

- Added Laravel 10 Support
- Added the `onlyIf` option to links that can conditionally render links based on closures or model properties

## 3.7.0
##### 2023-01-26

- Added the `PartialMatchInMultipleFields` filter
- Changed customer list name filter to search in `firstname`, `lastname` fields as well besides the `company_name` 

## 3.6.0
##### 2023-01-26

- Added pagination to customer and user lists (fixed 100 record page size)
- Added changing the Laravel Paginator style to Bootstrap 4
- Added `disable.paginator_style` configuration

## 3.5.1
##### 2022-12-05

- Fixed missing Tabler Icon assets by changing their CDN URL from unpkg to jsdelivr 🎅

## 3.5.0
##### 2022-09-21

- Fixed Unparenthesized ternary PHP Deprecation Error; thanks [Peterson Umoke](https://github.com/peterson-umoke)!
- Added explicit route parameters support for table actions widget
- Added PHP 8.2 support

## 3.4.0
##### 2022-09-02

- Added `spinner` and `plug` icons
- Added Font Awesome 6 Pro icon theme support
- Upgraded FontAwesome 6 Free icon theme to v6.2

## 3.3.0
##### 2022-08-31

- Added the `addAlias()` method to the resource permission mapper

## 3.2.0
##### 2022-08-31

- Added option to define ACL resource name aliases (eg 'master product' => 'product')

## 3.1.2
##### 2022-08-27

- Changed Laravel requirements to min v9.2 and to exclude v9.15.0 that puts the entire application down
- Reverted TreeBuilder container service to singleton (changed in 2.8.2) - as it never actually worked well
  The real fix for Octane based setup was added in Gears 1.10.0

## 3.1.1
##### 2022-06-02

- Changed the preferences tree container service from `singleton` to `scoped` (to fix corrupt data in Octane setup)

## 3.1.0
##### 2022-05-31

- Fixed Google Font import link at the top of appshell.sass that caused issues with newer Laravel Mix/SASS lib versions. See [laravel-mix#2430](https://github.com/laravel-mix/laravel-mix/issues/2430).
- Added custom asset links feature to the AppShell theme 

## 3.0.1
##### 2022-05-01

- Fixed the extra font loading by removing the surplus *Montserrat* font import from the layouts

> Added Frontend CI tests

## 3.0.0
##### 2022-04-29

- Dropped Laravel 8 Support (Laravel 9+ only)
- BC: Removed Vue.js and replaced it with Alpinejs (existing functionality has been ported to alpine)
- Changed the default AppShell theme (dark sidebar, narrower font, slightly different colors, and other visual aspects)
- Changed the `scripts` blade section from `yield()` to `stack()`
- Changed the footer position to the bottom of the sidebar
- Changed the default footer content to be empty (populate the `footer` blade section to add content)
- Fixed the footer underflow issue
- Deprecated the `id="app"` at the top of the layout in the default theme:
  - Applications should no longer rely on its existence
  - It will be removed in AppShell v4

## 2.8.1
##### 2022-04-27

- Fixed impossibility of editing own avatar without `edit users` permission

## 2.8.0
##### 2022-03-15

- Added opportunity to assign users to customers
- Added `timezone`, `currency` and `ltv` (Customer Lifetime Value) fields to customers (via Customers v2.3)
- Added model substitution to text widget's suffix and prefix options
- Added the default currency setting
- Improved the Customer create/edit forms
- Dropped Laravel 6 and 7 support
- Changed customer list so that inactive ones are hidden by default
- Changed minimal Laravel requirement to 8.22.1, see [CVE-2021-21263](https://blog.laravel.com/security-laravel-62011-7302-8221-released)
- Changed minimal package requirements to:
    - ACL module: 1.5
    - Address module: 2.1
    - Customer module: 2.3
    - Concord: 1.10.1
    - Eloquent Sluggable: 8.0.2
    - Enum Eloquent: 1.7
    - Gears module: 1.7
    - Laracasts Flash: 3.2
    - Laravel Collective HTML (Forms): 6.2.1
    - Menu module: 1.8

## 2.7.0
##### 2022-03-09

- Added `empty` option to "badges" widget that displays a default badge if the list is empty

## 2.6.0
##### 2022-02-22

- Added Laravel 9 support
- Added animation support to icons
- Added Font Awesome 6 icon theme

## 2.5.2
##### 2021-12-02

- Fixed misplaced form tags on quicklinks form
- Proven to work with PHP 8.1

## 2.5.1
##### 2021-10-23

- Fixed bug when search route wasn't defined

## 2.5.0
##### 2021-10-18

- Dropped PHP 7.4 Support
- Added actionbar and footer slots to the group widget
- Added possibility to omit the title from group widget
- Added "empty" option to table widget to render a text instead of table on empty dataset
- Added "header:false" option to hide table headers
- Added "value" option for getting a contextual color directly from the model
- Added Footer support to the table widget
- Added Raw HTML widget
- Added support for conditional widget rendering
- Added support for extra elements in multi text widget's primary row
- Added size and tooltip rendering to Avatar widget
- Added feature to fetch widget text from multiple model "depths" eg.: `$model.country.name`
- Changed customer and user show/edit/create pages to use group widget instead of hard coded Bootstrap
- Changed widget text modifiers so that they can modify non-string field values as well
- Converted address list partial to use the group widget instead of hardcoded bootstrap HTML
- Converted Invitations to render widgets instead of hardcoded Bootstrap HTML
- Converted Roles to render widgets instead of hardcoded Bootstrap HTML
- Fixed Table actions widget when delete confirmation was without translations parameters

## 2.4.2
##### 2021-10-04

- Fixed variable typo in public/print layouts that made them unusable

## 2.4.1
##### 2021-10-04

- Fixed greedy SHIFT keydown detection issue for search shortcut

## 2.4.0
##### 2021-10-04

- Added configuration (`ui.use_mix`) that allows applications to use `mix()` for AppShell Theme layout assets
- Added Search Feature

## 2.3.2
##### 2021-09-29

- Fixed rendering of custom classes on icon themes

## 2.3.1
##### 2021-09-22

- Fixed "stuck" old assets by replacing `asset()` with `mix()` in AppShell layouts

## 2.3.0
##### 2021-09-22

- Added Widgets feature
- Added Filters feature
- Replaced User and Customer list tables to be rendered via a table widget
- Added (enabled the Tabler Icon theme with

## 2.2.0
##### 2021-03-14

- Added print layout

## 2.1.0
##### 2020-12-21

- Added PHP 8 support 
- Added User Invitation Feature
- Changed placement of role on user form: moved to a new sidebar box on the right
- Changed CI from Travis to Github Actions

## 2.0.0
##### 2020-10-31

- Dropped Core UI
- AppShell Theme rework on top of plain Bootstrap 4
- AppShell Theme facelift
- Dropped Laravel 5 Support
- Dropped PHP 7.2 & 7.3 Support
- Renamed `appshell:super` artisan command to `make:superuser`
- BC: `semantic_color_to_hex` helper has been renamed to `theme_color`
- BC: ACL permission naming of resources with multipart names has been changed (eg. mapping of `userTypes`: was `user_types`/`usertypes` in 1.x, has become `user types` in 2.x)
- BC: Removed the configuration based asset injection support
- Added a blade based asset injection (into the default theme/layout)
- Added proper Theme support
- Added Icon Theme support
- Added Lineicons 2 and Fontawesome 5 icon themes besides Material Icons (ZMDI)
- Deprecated the `ResourcePermissions` static class in favour of the `ResourcePermissionMapper` singleton
- Improved Menu item activation (js workaround has been removed)
- AppShell logo uri can be set in config/settings
- Added config option `acl.allow_action_as_verb` to allow non-standard actions to be guarded by ACL
- Added possibility to configure the login/logout URLs
- Added Datetime format preferences and corresponding view helper functions (`show_date()`, `show_datetime()`, `show_time()`) 

## 1.8.1
##### 2020-09-24

- Fixed lazy loading issue with AppShell's default settings UI Tree. Thanks [majka brisova](https://github.com/briska)!

## 1.8.0
##### 2020-09-13

- Added Laravel 8 Support

## 1.7.0
##### 2020-05-24

- Added option to override default plurals for Resource permission generator

## 1.6.1
##### 2020-03-21

- Fixed buggy route definition for user activate/deactive

## 1.6.0
##### 2020-03-15

- Added Laravel 7 Support
- Added PHP 7.4 Support
- Dropped PHP 7.1 Support
- Concord 1.5+ is required

## 1.5.1
##### 2019-11-29

- Fixed displaying disallowed top level items on side menu

## 1.5.0
##### 2019-11-24

- Added Laravel 6 support
- Dropped Laravel 5.4 Support
- Concord 1.4+ is required

## 1.4.1
##### 2019-06-06

- Improved print CSS

## 1.4.0
##### 2019-06-06

- Minimalist Theme support has been added
- User preferences have been added (extensible, no defaults)

## 1.3.3
##### 2019-03-19

- Bugfix: Made migrations great again for cases when the `admin` role is not present in the system.

## 1.3.2
##### 2019-03-17

- Laravel 5.8 Compatibility fix

## 1.3.1
##### 2019-01-20

- Fixed can't build SASS issue (due to 'Top-level selectors may not contain the parent selector "&".')
- Documentation fixes

## 1.3.0
##### 2019-01-10

- Added possibility to define header/footer location of assets
- Removed PHP 7.0 support

## 1.2.0
##### 2018-11-11

- Custom URL function can be specified for individual assets (instead of default `asset()`)
- Fixed "Default Country too pushy" bug on address form
- Fixed bug of not-displaying "Address type" on address form
- Fixed validations on all forms to be Bootstrap 4 compliant
- Sidebar menu groups are opened when there's an active item (cheap solution)
- Works with PHP 7.3 (RC)

## 1.1.0
##### 2018-11-04

- Fixed missing bootstrap grid offset CSS classes
- Auth layout and AppShell look&feel login, register, pw reset views have been added
- Login counter feature can be disabled
- Documentation updates

## 1.0.0
##### 2018-11-02

- Profile, password change works
- Updated, standardized UI
- Delete confirmation globally works on DELETE forms
- Customer Address CRUD works
- Default Country can be set
- Improved Gravatar handling
- Added missing breadcrumbs
- Default layout assets are configurable
- Gears v1.1+
- Customer Module bumped to min. v0.9.6: customer has `last_purchase_at` field
- Documentation separated from readme. [Available here](https://artkonekt.github.io/appshell).

# 0.9

## 0.9.10
##### 2018-09-21

- Laravel 5.7 Support

## 0.9.9
##### 2018-07-23

- Menu items are authorized (based on ACL)
- Menu version bumped to 1.2

## 0.9.8
##### 2018-06-09

- A print stylesheet has been added
- Gears version bumped to 1.0+

## 0.9.7
##### 2018-05-27

- Settings support available (using gears 0.9.1)
- Minimum Concord version is 1.1


## 0.9.6
##### 2018-02-19

- Using konekt/acl v1.0 (for Laravel 5.6 support)
- Restored broken Laravel 5.4 compatibility

## 0.9.5
##### 2018-02-18

- Laravel 5.6 compatible
- UI improvements

## 0.9.4
##### 2018-01-10

- NEW FEATURE: Customer address editing
- Sidebar: security menu has been renamed to settings

## 0.9.3
##### 2017-12-11

- Composer deps bumped

## 0.9.2
##### 2017-12-08

- Concord min version is 0.9.9
- Documentation fixes

### 0.9.1
##### 2017-11-29

- Konekt Client library has been replaced with konekt/customer
- Default route prefix is /appshell => /admin

### 0.9.0
##### 2017-11-24

- Version tracking and Changelog has started
