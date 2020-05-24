# AppShell Changelog

## Unreleased
##### 2020-XX-XX

- Dropped Core UI
- AppShell Theme rework on top of plain Bootstrap 4
- AppShell Theme facelift
- Dropped Laravel 5 Support
- Improved Menu item activation (js workaround has been removed)
- AppShell logo uri can be set in config/settings

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
